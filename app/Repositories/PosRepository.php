<?php

namespace App\Repositories;

use App\Models\Shift;
use App\Models\StokCabang;
use App\Models\LogManajemenStok;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Exception;
use Illuminate\Support\Facades\DB;

class PosRepository
{
    /**
     * Mengambil daftar produk untuk beranda kasir (Fisik)
     */
    public function getProdukPos($user, $search = null, $kategori = null)
    {
        $id_cabang = $user->id_cabang;

        $query = StokCabang::with(['produk.kategori'])
            ->where('id_cabang', $id_cabang);

        // Filter Pencarian (Nama / Barcode / SKU)
        if (!empty($search)) {
            $query->whereHas('produk', function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode_imei', 'like', "%{$search}%");
            });
        }

        // Filter Kategori (Misal: "Aksesoris", "Smartphone")
        if (!empty($kategori) && strtolower($kategori) !== 'semua') {
            $query->whereHas('produk', function ($q) use ($kategori) {
                $q->whereHas('kategori', function ($q2) use ($kategori) {
                    $q2->where('nama_kategori', 'like', "%{$kategori}%");
                });
            });
        }

        // Ambil data dengan Pagination
        $paginatedData = $query->paginate(20);

        $formattedItems = collect($paginatedData->items())->map(function ($item) {
            return [
                'id_produk' => $item->produk->id_produk,
                'nama_produk' => $item->produk->nama_produk,
                'kategori' => $item->produk->kategori->nama_kategori ?? '-',
                'harga_beli' => $item->produk->harga_beli,
                'harga_jual' => $item->produk->harga_jual,
                'stok_sekarang' => $item->stok_sekarang,
                'sku' => $item->produk->sku,
                'barcode_imei' => $item->produk->barcode_imei,
                'foto_produk' => $item->produk->foto_produk
            ];
        });

        return [
            'produk' => $formattedItems,
            'pagination' => [
                'current_page' => $paginatedData->currentPage(),
                'last_page' => $paginatedData->lastPage(),
            ]
        ];
    }

    /**
     * Memproses Checkout Keranjang
     */
    public function prosesCheckout($user, $data)
    {
        // 1. Validasi Shift Aktif
        $shiftAktif = Shift::where('id_user', $user->id_user)
            ->where('status', 'buka')
            ->first();

        if (!$shiftAktif) {
            throw new Exception("Anda harus membuka shift terlebih dahulu sebelum melakukan transaksi.");
        }

        // 2. Mulai Database Transaction agar jika error, data otomatis ter-rollback
        return DB::transaction(function () use ($user, $shiftAktif, $data) {
            
            $noTransaksi = 'RX-' . date('Ymd-His') . '-' . rand(100, 999);
            
            $metodeBayar = strtolower($data['metode_pembayaran']);
            if (!in_array($metodeBayar, ['tunai', 'qris', 'transfer'])) {
                $metodeBayar = 'tunai';
            }

            // Buat Record Transaksi Utama
            $transaksi = Transaksi::create([
                'id_user' => $user->id_user,
                'id_cabang' => $user->id_cabang,
                'id_shift' => $shiftAktif->id_shift,
                'no_transaksi' => $noTransaksi,
                'tanggal_transaksi' => now(),
                'total_harga' => 0, // Akan diupdate nanti
                'metode_bayar' => $metodeBayar,
                'uang_bayar' => $data['uang_bayar'] ?? 0,
                'kembalian' => $data['kembalian'] ?? 0,
            ]);

            $totalHargaSistem = 0;

            // 3. Looping Items (Fisik dan Manual)
            foreach ($data['items'] as $item) {
                $subTotal = 0;

                if ($item['tipe'] === 'fisik') {
                    // Cek Stok Cabang & Ambil Harga
                    $stokCabang = StokCabang::with('produk')->where('id_produk', $item['id_produk'])
                        ->where('id_cabang', $user->id_cabang)
                        ->first();

                    if (!$stokCabang) {
                        throw new Exception("Produk dengan ID {$item['id_produk']} tidak ditemukan di cabang ini.");
                    }

                    if ($stokCabang->stok_sekarang < $item['qty']) {
                        throw new Exception("Stok untuk {$stokCabang->produk->nama_produk} tidak mencukupi. (Sisa: {$stokCabang->stok_sekarang})");
                    }

                    // Potong Stok
                    $stokSebelum = $stokCabang->stok_sekarang;
                    $stokCabang->decrement('stok_sekarang', $item['qty']);
                    
                    // Buat Log Manajemen Stok
                    LogManajemenStok::create([
                        'id_cabang' => $user->id_cabang,
                        'id_produk' => $item['id_produk'],
                        'id_user' => $user->id_user,
                        'qty' => $item['qty'],
                        'jenis_transaksi' => 'Keluar',
                        'stok_sebelum' => $stokSebelum,
                        'stok_sesudah' => $stokSebelum - $item['qty'],
                        'keterangan' => 'Penjualan POS ' . $noTransaksi,
                        'tanggal' => now(),
                    ]);

                    $hargaBeli = $stokCabang->produk->harga_beli;
                    $hargaJual = $stokCabang->produk->harga_jual;
                    $subTotal = $hargaJual * $item['qty'];

                    // Simpan Detail Fisik
                    DetailTransaksi::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'id_produk' => $item['id_produk'],
                        'qty' => $item['qty'],
                        'harga_beli_realtime' => $hargaBeli,
                        'harga_jual_realtime' => $hargaJual,
                        'sub_total' => $subTotal,
                        'kategori_layanan' => 'Barang Fisik'
                    ]);

                } else if ($item['tipe'] === 'manual') {
                    // Transaksi PPOB / Tambah Manual
                    $hargaBeli = $item['harga_beli'];
                    $hargaJual = $item['harga_jual'];
                    $subTotal = $hargaJual * $item['qty'];

                    // Simpan Detail Manual (id_produk = null)
                    DetailTransaksi::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'id_produk' => null, // Nullable di DB
                        'nama_item_manual' => $item['nama_item_manual'],
                        'nomor_tujuan' => $item['nomor_tujuan'] ?? null,
                        'kategori_layanan' => $item['kategori_layanan'], // "Pulsa", "Token PLN"
                        'qty' => $item['qty'],
                        'harga_beli_realtime' => $hargaBeli,
                        'harga_jual_realtime' => $hargaJual,
                        'sub_total' => $subTotal,
                    ]);
                }

                $totalHargaSistem += $subTotal;
            }

            // 4. Update Total Harga Transaksi
            $transaksi->update([
                'total_harga' => $totalHargaSistem,
                'uang_bayar' => $totalHargaSistem, // Asumsi bayar pas jika tidak diinput kembalian
                'kembalian' => 0
            ]);

            return [
                'transaksi' => $transaksi,
                'order_id_formatted' => $noTransaksi,
                'waktu' => date('d M Y, H:i', strtotime($transaksi->tanggal_transaksi)),
                'metode_pembayaran' => ucfirst($transaksi->metode_bayar),
                'total_transaksi' => $totalHargaSistem
            ];
        });
    }
}
