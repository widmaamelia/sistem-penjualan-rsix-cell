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

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_transaksi', $request->tanggal);
        }

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('tanggal_transaksi', $request->bulan)
                  ->whereYear('tanggal_transaksi', $request->tahun);
        } elseif ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
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

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('tanggal', $request->bulan)
                  ->whereYear('tanggal', $request->tahun);
        } elseif ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        // Jika Super Admin dan tidak sedang membuka detail cabang spesifik
        if ($user->role === 'super' && !$request->filled('id_cabang')) {
            $cabangs = Cabang::all();
            
            // Hitung global total
            $globalQuery = $this->buildQuery($request);
            $allTransGlobal = $globalQuery->get();
            $globalOmzet = $allTransGlobal->sum('total_harga');
            $globalTransaksi = $allTransGlobal->count();
            
            $globalLaba = 0;
            foreach ($allTransGlobal as $t) {
                foreach ($t->detailTransaksis as $d) {
                    $globalLaba += ($d->harga_jual_realtime - $d->harga_beli_realtime) * $d->qty;
                }
            }

            // Hitung global kas keluar
            $globalKasKeluar = $this->buildKasKeluarQuery($request)->sum('jumlah_pengeluaran');
            $globalUangMasuk = $globalOmzet;
            $globalUangKeluar = $globalKasKeluar;

            // Hitung per cabang
            foreach ($cabangs as $cabang) {
                $cabangReq = clone $request;
                $cabangReq->merge(['id_cabang' => $cabang->id_cabang]);
                $cQuery = $this->buildQuery($cabangReq);
                $cTrans = $cQuery->get();

                $cabang->total_transaksi = $cTrans->count();
                $cabang->total_omzet = $cTrans->sum('total_harga');
                
                $cLaba = 0;
                foreach ($cTrans as $t) {
                    foreach ($t->detailTransaksis as $d) {
                        $cLaba += ($d->harga_jual_realtime - $d->harga_beli_realtime) * $d->qty;
                    }
                }
                $cabang->total_laba = $cLaba;

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
        $allTrans = $summaryQuery->get();

        $totalOmzet = $allTrans->sum('total_harga');
        $totalTransaksi = $allTrans->count();
        
        $labaKotor = 0;
        foreach ($allTrans as $t) {
            foreach ($t->detailTransaksis as $d) {
                $labaKotor += ($d->harga_jual_realtime - $d->harga_beli_realtime) * $d->qty;
            }
        }

        // Kas keluar local cabang
        $totalKasKeluar = $this->buildKasKeluarQuery($request)->sum('jumlah_pengeluaran');
        $totalUangMasuk = $totalOmzet;
        $totalUangKeluar = $totalKasKeluar;

        $kasKeluars = $this->buildKasKeluarQuery($request)->orderBy('tanggal', 'desc')->get();

        $transaksis = $query->orderBy('tanggal_transaksi', 'desc')->paginate(15)->withQueryString();
        
        $cabangSpesifik = null;
        if ($user->role === 'super' && $request->filled('id_cabang')) {
            $cabangSpesifik = Cabang::find($request->id_cabang);
        }

        return view('admin.laporan.index', compact(
            'transaksis', 'totalOmzet', 'totalTransaksi', 'labaKotor', 'cabangSpesifik',
            'totalKasKeluar', 'totalUangMasuk', 'totalUangKeluar', 'kasKeluars'
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

    public function print(Request $request)
    {
        $query = $this->buildQuery($request);
        $transaksis = $query->orderBy('tanggal_transaksi', 'desc')->get();

        $totalOmzet = $transaksis->sum('total_harga');
        $totalTransaksi = $transaksis->count();
        
        $labaKotor = 0;
        foreach ($transaksis as $t) {
            foreach ($t->detailTransaksis as $d) {
                $labaKotor += ($d->harga_jual_realtime - $d->harga_beli_realtime) * $d->qty;
            }
        }

        $totalKasKeluar = $this->buildKasKeluarQuery($request)->sum('jumlah_pengeluaran');
        $totalUangMasuk = $totalOmzet;
        $totalUangKeluar = $totalKasKeluar;

        $kasKeluars = $this->buildKasKeluarQuery($request)->orderBy('tanggal', 'desc')->get();

        return view('admin.laporan.print', compact(
            'transaksis', 'totalOmzet', 'totalTransaksi', 'labaKotor',
            'totalKasKeluar', 'totalUangMasuk', 'totalUangKeluar', 'kasKeluars'
        ));
    }

    public function exportPdf(Request $request)
    {
        $query = $this->buildQuery($request);
        $transaksis = $query->orderBy('tanggal_transaksi', 'desc')->get();

        $totalOmzet = $transaksis->sum('total_harga');
        $totalTransaksi = $transaksis->count();
        
        $labaKotor = 0;
        foreach ($transaksis as $t) {
            foreach ($t->detailTransaksis as $d) {
                $labaKotor += ($d->harga_jual_realtime - $d->harga_beli_realtime) * $d->qty;
            }
        }

        $totalKasKeluar = $this->buildKasKeluarQuery($request)->sum('jumlah_pengeluaran');
        $totalUangMasuk = $totalOmzet;
        $totalUangKeluar = $totalKasKeluar;

        $kasKeluars = $this->buildKasKeluarQuery($request)->orderBy('tanggal', 'desc')->get();
        
        $pdf = Pdf::loadView('admin.laporan.pdf', compact(
            'transaksis', 'totalOmzet', 'totalTransaksi', 'labaKotor',
            'totalKasKeluar', 'totalUangMasuk', 'totalUangKeluar', 'kasKeluars'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan_transaksi_'.date('Ymd').'.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = $this->buildQuery($request);
        $transaksis = $query->orderBy('tanggal_transaksi', 'desc')->get();

        $filename = "laporan_transaksi_" . date('Ymd') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Transaksi', 'No Transaksi', 'Tanggal', 'Cabang', 'Kasir', 'Metode Bayar', 'Total Harga'];

        $callback = function() use($transaksis, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transaksis as $t) {
                fputcsv($file, [
                    $t->id_transaksi,
                    $t->no_transaksi,
                    $t->tanggal_transaksi,
                    $t->cabang->nama_cabang ?? '-',
                    $t->user->name ?? '-',
                    $t->metode_bayar,
                    $t->total_harga
                ]);
            }


            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
