<?php

namespace App\Repositories;

use App\Models\StokCabang;
use Illuminate\Http\Request;

class StokRepository
{
    /**
     * Mengambil data halaman manajemen stok beserta filter dan pencarian.
     */
    public function getHalamanStok($user, $search = null, $filter = 'semua')
    {
        $id_cabang = $user->id_cabang;

        // 1. Ambil Query Dasar (Relasi Produk & Kategori)
        $query = StokCabang::with(['produk.kategori'])
            ->where('id_cabang', $id_cabang);

        // Hitung Statistik Dasar (Berdasarkan Query Dasar Tanpa Filter String)
        $totalProduk = (clone $query)->count();
        $stokMenipisCount = (clone $query)->whereColumn('stok_sekarang', '<=', 'stok_minimum')->where('stok_sekarang', '>', 0)->count();
        $stokHabisCount = (clone $query)->where('stok_sekarang', 0)->count();

        // 2. Terapkan Filter Pencarian (Nama Produk / SKU)
        if (!empty($search)) {
            $query->whereHas('produk', function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // 3. Terapkan Filter Kategori Stok (Semua, Menipis, Tersedia)
        // Di UI: "Semua", "Stok Menipis", "Tersedia"
        if ($filter === 'menipis') {
            $query->whereColumn('stok_sekarang', '<=', 'stok_minimum')
                  ->where('stok_sekarang', '>', 0);
        } elseif ($filter === 'habis') { // Opsional jika dari kotak statistik bisa di-klik
            $query->where('stok_sekarang', 0);
        } elseif ($filter === 'tersedia') {
            $query->where('stok_sekarang', '>', 0);
        }

        // 4. Ambil Data dengan Pagination (Limit 20 per halaman untuk performa mobile)
        $paginatedData = $query->paginate(20);

        // Format ulang struktur item
        $formattedItems = collect($paginatedData->items())->map(function ($item) {
            $status_stok = 'STOK AMAN';
            if ($item->stok_sekarang == 0) {
                $status_stok = 'STOK HABIS';
            } elseif ($item->stok_sekarang <= $item->stok_minimum) {
                $status_stok = 'MENIPIS';
            }

            return [
                'id_stok_cabang' => $item->id_stok_cabang,
                'id_produk' => $item->produk->id_produk,
                'nama_produk' => $item->produk->nama_produk,
                'kategori' => $item->produk->kategori ? $item->produk->kategori->nama_kategori : '-',
                'foto_produk' => $item->produk->foto_produk,
                'stok_sekarang' => $item->stok_sekarang,
                'stok_minimum' => $item->stok_minimum,
                'status_stok' => $status_stok
            ];
        });

        return [
            'statistik' => [
                'total_produk' => $totalProduk,
                'stok_menipis' => $stokMenipisCount,
                'stok_habis' => $stokHabisCount
            ],
            'produk' => $formattedItems,
            'pagination' => [
                'current_page' => $paginatedData->currentPage(),
                'last_page' => $paginatedData->lastPage(),
                'per_page' => $paginatedData->perPage(),
                'total' => $paginatedData->total()
            ]
        ];
    }
}
