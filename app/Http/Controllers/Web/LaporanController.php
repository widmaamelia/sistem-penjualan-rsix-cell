<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Cabang;
use App\Models\KasKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    private function buildQuery(Request $request)
    {
        $user = auth()->user();
        $query = Transaksi::with(['user', 'cabang', 'detailTransaksis.produk']);

        if ($user->role === 'admin cabang') {
            $query->where('id_cabang', $user->id_cabang);
        } elseif ($user->role === 'super' && $request->filled('id_cabang')) {
            $query->where('id_cabang', $request->id_cabang);
        }

        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) === 2) {
                // Range tanggal (dari - sampai)
                $query->whereDate('tanggal_transaksi', '>=', trim($dates[0]))
                      ->whereDate('tanggal_transaksi', '<=', trim($dates[1]));
            } elseif (count($dates) === 1) {
                // Hanya 1 tanggal dipilih
                $query->whereDate('tanggal_transaksi', trim($dates[0]));
            }
        }

        if ($request->filled('id_user')) {
            $query->where('id_user', $request->id_user);
        }

        return $query;
    }

    private function buildKasKeluarQuery(Request $request)
    {
        $user = auth()->user();
        $query = KasKeluar::with(['shift.cabang', 'shift.user']);

        if ($user->role === 'admin cabang') {
            $query->where(function ($q) use ($user) {
                $q->where('id_cabang', $user->id_cabang)
                  ->orWhereHas('shift', function ($sq) use ($user) {
                      $sq->where('id_cabang', $user->id_cabang);
                  });
            });
        } elseif ($user->role === 'super' && $request->filled('id_cabang')) {
            $query->where(function ($q) use ($request) {
                $q->where('id_cabang', $request->id_cabang)
                  ->orWhereHas('shift', function ($sq) use ($request) {
                      $sq->where('id_cabang', $request->id_cabang);
                  });
            });
        }

        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) === 2) {
                $query->whereDate('tanggal', '>=', trim($dates[0]))
                      ->whereDate('tanggal', '<=', trim($dates[1]));
            } elseif (count($dates) === 1) {
                $query->whereDate('tanggal', trim($dates[0]));
            }
        }

        if ($request->filled('id_user')) {
            $query->whereHas('shift', function ($sq) use ($request) {
                $sq->where('id_user', $request->id_user);
            });
        }

        return $query;
    }

    /**
     * Memisahkan uang keluar menjadi pembelian barang stok dan pengeluaran
     * operasional. Polanya sama dengan badge "Tipe Pengeluaran" di halaman
     * Kas Keluar, supaya angkanya konsisten di semua halaman dan export.
     */
    private function kasKeluarTerpisah(Request $request)
    {
        $filterPembelian = function ($q) {
            $q->where('keterangan', 'like', '%restock%')
              ->orWhere('keterangan', 'like', '%opname%');
        };

        $pembelianStoks = $this->buildKasKeluarQuery($request)
            ->where($filterPembelian)->orderBy('tanggal', 'desc')->get();

        $operasionals = $this->buildKasKeluarQuery($request)
            ->whereNot($filterPembelian)->orderBy('tanggal', 'desc')->get();

        return [
            'pembelianStoks' => $pembelianStoks,
            'operasionals' => $operasionals,
            'totalPembelianStok' => $pembelianStoks->sum('jumlah_pengeluaran'),
            'totalOperasional' => $operasionals->sum('jumlah_pengeluaran'),
        ];
    }

    /**
     * Menghitung laba kotor dari sekumpulan transaksi.
     * Memakai harga beli yang tersimpan saat transaksi terjadi.
     */
    private function hitungLabaKotor($transaksis)
    {
        $laba = 0;

        foreach ($transaksis as $t) {
            foreach ($t->detailTransaksis as $d) {
                $laba += ($d->harga_jual_realtime - $d->harga_beli_realtime) * $d->qty;
            }
        }

        return $laba;
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        // Default Filter: Bulan Ini (agar tidak meload semua data sepanjang masa jika dibuka kosong)
        // Berlaku jika tidak ada filter date_range sama sekali
        if (!$request->has('date_range')) {
            $start = now()->startOfMonth()->format('Y-m-d');
            $end = now()->endOfMonth()->format('Y-m-d');
            
            $params = $request->all();
            $params['date_range'] = "$start to $end";
            
            return redirect()->route('laporan.index', $params);
        }

        // Jika Super Admin dan tidak sedang membuka detail cabang spesifik
        if ($user->role === 'super' && !$request->filled('id_cabang')) {
            $cabangs = Cabang::all();
            
            // Hitung global total menggunakan Aggregate Database (tanpa meload model)
            $globalQuery = $this->buildQuery($request);
            
            $globalTransaksi = $globalQuery->count();
            $globalOmzet = $globalQuery->sum('total_harga');
            
            // Hitung laba kotor lewat join (sangat cepat untuk jutaan data)
            $labaQuery = clone $globalQuery;
            $globalLaba = $labaQuery->join('detail_transaksis', 'transaksis.id_transaksi', '=', 'detail_transaksis.id_transaksi')
                ->selectRaw('SUM((detail_transaksis.harga_jual_realtime - detail_transaksis.harga_beli_realtime) * detail_transaksis.qty) as total_laba')
                ->value('total_laba') ?? 0;

            // Hitung global kas keluar
            $globalKasKeluar = $this->buildKasKeluarQuery($request)->sum('jumlah_pengeluaran');
            $globalUangMasuk = $globalOmzet;
            $globalUangKeluar = $globalKasKeluar;

            // Hitung per cabang
            foreach ($cabangs as $cabang) {
                $cabangReq = clone $request;
                $cabangReq->merge(['id_cabang' => $cabang->id_cabang]);
                $cQuery = $this->buildQuery($cabangReq);

                $cabang->total_transaksi = $cQuery->count();
                $cabang->total_omzet = $cQuery->sum('total_harga');
                
                $cLabaQuery = clone $cQuery;
                $cabang->total_laba = $cLabaQuery->join('detail_transaksis', 'transaksis.id_transaksi', '=', 'detail_transaksis.id_transaksi')
                    ->selectRaw('SUM((detail_transaksis.harga_jual_realtime - detail_transaksis.harga_beli_realtime) * detail_transaksis.qty) as total_laba')
                    ->value('total_laba') ?? 0;

                $cabang->total_kas_keluar = $this->buildKasKeluarQuery($cabangReq)->sum('jumlah_pengeluaran');
                $cabang->total_uang_masuk = $cabang->total_omzet;
                $cabang->total_uang_keluar = $cabang->total_kas_keluar;
            }

            return view('admin.laporan.index_super', compact(
                'cabangs', 'globalOmzet', 'globalTransaksi', 'globalLaba',
                'globalKasKeluar', 'globalUangMasuk', 'globalUangKeluar'
            ));
        }

        // --- Logika untuk Admin Cabang ATAU Super Admin yang sedang buka 1 cabang ---
        $query = $this->buildQuery($request);
        
        $summaryQuery = clone $query;
        
        $totalTransaksi = $summaryQuery->count();
        $totalOmzet = $summaryQuery->sum('total_harga');
        
        $labaQuery = clone $query;
        $labaKotor = $labaQuery->join('detail_transaksis', 'transaksis.id_transaksi', '=', 'detail_transaksis.id_transaksi')
            ->selectRaw('SUM((detail_transaksis.harga_jual_realtime - detail_transaksis.harga_beli_realtime) * detail_transaksis.qty) as total_laba')
            ->value('total_laba') ?? 0;

        // Kas keluar local cabang
        $totalKasKeluar = $this->buildKasKeluarQuery($request)->sum('jumlah_pengeluaran');
        $totalUangMasuk = $totalOmzet;
        $totalUangKeluar = $totalKasKeluar;

        $kasKeluars = $this->buildKasKeluarQuery($request)->orderBy('tanggal', 'desc')->get();

        $transaksis = $query->orderBy('tanggal_transaksi', 'desc')->paginate(10)->withQueryString();
        
        $cabangSpesifik = null;
        $id_cabang_filter = $user->id_cabang;
        if ($user->role === 'super' && $request->filled('id_cabang')) {
            $cabangSpesifik = Cabang::find($request->id_cabang);
            $id_cabang_filter = $request->id_cabang;
        }
        
        $karyawans = collect();
        if ($id_cabang_filter) {
            $karyawans = \App\Models\User::where('id_cabang', $id_cabang_filter)->get();
        }

        return view('admin.laporan.index', array_merge(
            compact(
                'transaksis', 'totalOmzet', 'totalTransaksi', 'labaKotor', 'cabangSpesifik',
                'totalKasKeluar', 'totalUangMasuk', 'totalUangKeluar', 'kasKeluars', 'karyawans'
            ),
            $this->kasKeluarTerpisah($request)
        ));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['user', 'cabang', 'detailTransaksis.produk'])->findOrFail($id);
        
        $user = auth()->user();
        if ($user->role === 'admin cabang' && $transaksi->id_cabang !== $user->id_cabang) {
            return abort(403);
        }

        return view('admin.laporan.show', compact('transaksi'));
    }

    /**
     * Data yang dipakai bersama oleh halaman print dan export PDF,
     * isinya sama persis dengan yang tampil di halaman laporan.
     */
    private function dataCetak(Request $request)
    {
        $transaksis = $this->buildQuery($request)->orderBy('tanggal_transaksi', 'desc')->get();

        $totalOmzet = $transaksis->sum('total_harga');
        $totalTransaksi = $transaksis->count();
        $labaKotor = $this->hitungLabaKotor($transaksis);

        $totalKasKeluar = $this->buildKasKeluarQuery($request)->sum('jumlah_pengeluaran');
        $totalUangMasuk = $totalOmzet;
        $totalUangKeluar = $totalKasKeluar;

        $kasKeluars = $this->buildKasKeluarQuery($request)->orderBy('tanggal', 'desc')->get();

        return array_merge(
            compact(
                'transaksis', 'totalOmzet', 'totalTransaksi', 'labaKotor',
                'totalKasKeluar', 'totalUangMasuk', 'totalUangKeluar', 'kasKeluars'
            ),
            $this->kasKeluarTerpisah($request)
        );
    }

    public function print(Request $request)
    {
        return view('admin.laporan.print', $this->dataCetak($request));
    }

    public function exportPdf(Request $request)
    {
        $pdf = Pdf::loadView('admin.laporan.pdf', $this->dataCetak($request))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan_transaksi_'.date('Ymd').'.pdf');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->dataCetak($request);

        $filename = "laporan_transaksi_" . date('Ymd') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // BOM UTF-8 supaya huruf beraksen tidak berantakan saat dibuka Excel.
            fwrite($file, "\xEF\xBB\xBF");

            // Excel dengan pengaturan regional Indonesia memakai titik koma sebagai
            // pemisah kolom. Baris "sep=;" memberi tahu Excel pemisah yang dipakai,
            // sehingga file terbuka rapi per kolom di komputer mana pun.
            fwrite($file, "sep=;\n");

            $tulis = function (array $baris = []) use ($file) {
                fputcsv($file, $baris, ';');
            };

            // 1. Ringkasan
            $tulis(['RINGKASAN LAPORAN']);
            $tulis(['Total Transaksi', $data['totalTransaksi']]);
            $tulis(['Total Uang Masuk', $data['totalOmzet']]);
            $tulis(['Total Modal Barang Terjual', $data['totalOmzet'] - $data['labaKotor']]);
            $tulis(['Total Laba Kotor', $data['labaKotor']]);
            $tulis(['Pengeluaran Operasional', $data['totalOperasional']]);
            $tulis(['Pembelian Barang Stok', $data['totalPembelianStok']]);
            $tulis(['Total Uang Keluar', $data['totalUangKeluar']]);
            $tulis([]);

            // 2. Riwayat transaksi
            $tulis(['RIWAYAT TRANSAKSI (UANG MASUK)']);
            $tulis([
                'No Transaksi', 'Tanggal', 'Cabang', 'Kasir', 'Metode Bayar',
                'Modal', 'Laba', 'Total'
            ]);

            foreach ($data['transaksis'] as $t) {
                $modal = 0;
                foreach ($t->detailTransaksis as $d) {
                    $modal += $d->harga_beli_realtime * $d->qty;
                }

                $tulis([
                    $t->no_transaksi,
                    $t->tanggal_transaksi,
                    $t->cabang->nama_cabang ?? '-',
                    $t->user->name ?? '-',
                    $t->metode_bayar,
                    $modal,
                    $t->total_harga - $modal,
                    $t->total_harga,
                ]);
            }

            $tulis([
                'TOTAL', '', '', '', '',
                $data['totalOmzet'] - $data['labaKotor'],
                $data['labaKotor'],
                $data['totalOmzet'],
            ]);
            $tulis([]);

            // 3. Rincian per barang, supaya laba tiap produk terlihat
            $tulis(['RINCIAN PER BARANG']);
            $tulis([
                'No Transaksi', 'Tanggal', 'Produk / Item', 'Qty',
                'Harga Beli', 'Harga Jual', 'Laba per Unit', 'Subtotal', 'Laba'
            ]);

            foreach ($data['transaksis'] as $t) {
                foreach ($t->detailTransaksis as $d) {
                    $tulis([
                        $t->no_transaksi,
                        $t->tanggal_transaksi,
                        $d->produk->nama_produk ?? $d->nama_item_manual ?? 'Produk',
                        $d->qty,
                        $d->harga_beli_realtime,
                        $d->harga_jual_realtime,
                        $d->harga_jual_realtime - $d->harga_beli_realtime,
                        $d->sub_total,
                        ($d->harga_jual_realtime - $d->harga_beli_realtime) * $d->qty,
                    ]);
                }
            }
            $tulis([]);

            // 4. Uang keluar, dipisah sesuai tampilan laporan
            $tulis(['PENGELUARAN OPERASIONAL']);
            $tulis(['Tanggal', 'Keterangan', 'Nominal']);
            foreach ($data['operasionals'] as $kk) {
                $tulis([$kk->tanggal, $kk->keterangan, $kk->jumlah_pengeluaran]);
            }
            $tulis(['TOTAL OPERASIONAL', '', $data['totalOperasional']]);
            $tulis([]);

            $tulis(['PEMBELIAN BARANG STOK']);
            $tulis(['Tanggal', 'Keterangan', 'Nominal']);
            foreach ($data['pembelianStoks'] as $kk) {
                $tulis([$kk->tanggal, $kk->keterangan, $kk->jumlah_pengeluaran]);
            }
            $tulis(['TOTAL PEMBELIAN STOK', '', $data['totalPembelianStok']]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}