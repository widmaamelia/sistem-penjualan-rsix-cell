<?php

namespace App\Repositories;

use App\Models\Transaksi;

class RiwayatRepository
{
    /**
     * Mengambil daftar riwayat transaksi untuk cabang kasir saat ini dengan berbagai filter
     */
    public function getRiwayat($user, $filters)
    {
        $query = Transaksi::where('id_cabang', $user->id_cabang);

        // Filter Pencarian (Berdasarkan Order ID)
        if (!empty($filters['search'])) {
            $query->where('no_transaksi', 'like', '%' . $filters['search'] . '%');
        }

        // Filter Tanggal, Bulan, Tahun
        if (!empty($filters['tanggal'])) {
            $query->whereDay('tanggal_transaksi', $filters['tanggal']);
        }
        if (!empty($filters['bulan'])) {
            $query->whereMonth('tanggal_transaksi', $filters['bulan']);
        }
        if (!empty($filters['tahun'])) {
            $query->whereYear('tanggal_transaksi', $filters['tahun']);
        }

        // Filter Metode Pembayaran
        if (!empty($filters['metode_bayar']) && strtolower($filters['metode_bayar']) !== 'semua') {
            $metode = strtolower($filters['metode_bayar']);
            if ($metode === 'tunai') {
                $query->where('metode_bayar', 'tunai');
            } else if ($metode === 'non-tunai') {
                $query->whereIn('metode_bayar', ['qris', 'transfer']);
            } else {
                // Untuk spesifik qris atau transfer
                $query->where('metode_bayar', $metode);
            }
        }

        // Urutkan dari yang terbaru
        $query->orderBy('tanggal_transaksi', 'desc');

        // Paginasi
        $paginatedData = $query->paginate(20);

        // Format data untuk respons UI
        $formattedItems = collect($paginatedData->items())->map(function ($trx) {
            return [
                'id_transaksi' => $trx->id_transaksi,
                'no_transaksi' => $trx->no_transaksi,
                'waktu' => date('H:i', strtotime($trx->tanggal_transaksi)),
                'tanggal_lengkap' => date('d M Y, H:i', strtotime($trx->tanggal_transaksi)),
                'metode_bayar' => ucfirst($trx->metode_bayar),
                'total_harga' => $trx->total_harga
            ];
        });

        return [
            'transaksi' => $formattedItems,
            'pagination' => [
                'current_page' => $paginatedData->currentPage(),
                'last_page' => $paginatedData->lastPage(),
                'total' => $paginatedData->total()
            ]
        ];
    }

    /**
     * Mengambil rincian spesifik sebuah transaksi
     */
    public function getDetailRiwayat($user, $id_transaksi)
    {
        $transaksi = Transaksi::with(['detailTransaksis.produk'])
            ->where('id_cabang', $user->id_cabang)
            ->where('id_transaksi', $id_transaksi)
            ->first();

        if (!$transaksi) {
            throw new \Exception("Transaksi tidak ditemukan.");
        }

        $items = $transaksi->detailTransaksis->map(function ($detail) {
            $isFisik = $detail->id_produk !== null;
            
            return [
                'tipe' => $isFisik ? 'fisik' : 'manual',
                'nama_produk' => $isFisik ? $detail->produk->nama_produk : $detail->nama_item_manual,
                'kategori' => $isFisik ? ($detail->produk->kategori->nama_kategori ?? 'Barang Fisik') : $detail->kategori_layanan,
                'qty' => $detail->qty,
                'harga_satuan' => $detail->harga_jual_realtime,
                'sub_total' => $detail->sub_total,
                'foto_produk' => $isFisik ? $detail->produk->foto_produk : null, // Manual item doesn't have photo
            ];
        });

        return [
            'no_transaksi' => $transaksi->no_transaksi,
            'status' => 'Berhasil', // Selalu berhasil jika sudah tercatat di tabel transaksis
            'waktu' => date('d M Y, H:i', strtotime($transaksi->tanggal_transaksi)),
            'items' => $items,
            'ringkasan_pembayaran' => [
                'total_harga' => $transaksi->total_harga,
                'total_bayar' => $transaksi->uang_bayar ?? $transaksi->total_harga,
                'metode_bayar' => ucfirst($transaksi->metode_bayar),
                'diterima' => $transaksi->uang_bayar ?? $transaksi->total_harga,
                'kembalian' => $transaksi->kembalian ?? 0
            ]
        ];
    }
}
