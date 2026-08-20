<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaksi;
use App\Models\Cabang;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        $isSuper = $user->role === 'super';
        $id_cabang = $isSuper ? null : $user->id_cabang;

        // 1. Data Statistik (Card)
        $pendapatanQuery = Transaksi::whereDate('tanggal_transaksi', $today);
        $transaksiQuery = Transaksi::whereDate('tanggal_transaksi', $today);
        $karyawanQuery = User::where('role', 'karyawan')->where('status', 'aktif');

        if (!$isSuper) {
            $pendapatanQuery->where('id_cabang', $id_cabang);
            $transaksiQuery->where('id_cabang', $id_cabang);
            $karyawanQuery->where('id_cabang', $id_cabang);
        }

        $pendapatanHariIni = $pendapatanQuery->sum('total_harga');
        $totalTransaksiHariIni = $transaksiQuery->count();
        $karyawanBertugas = $karyawanQuery->count();

        if ($isSuper) {
            $cabangAktif = Cabang::where('status', 'aktif')->count();
            $totalCabang = Cabang::count();
            $labelCabang = 'Cabang Aktif';
            $nilaiCabang = "{$cabangAktif}/{$totalCabang}";
        } else {
            // Untuk Admin Cabang, tampilkan total produk stok rendah di cabangnya
            $labelCabang = 'Stok Rendah';
            $nilaiCabang = \App\Models\StokCabang::where('id_cabang', $id_cabang)
                ->whereColumn('stok_sekarang', '<=', 'stok_minimum')
                ->count();
        }

        $statistik = [
            'pendapatan' => $pendapatanHariIni,
            'total_transaksi' => $totalTransaksiHariIni,
            'karyawan' => $karyawanBertugas,
            'label_cabang' => $labelCabang,
            'nilai_cabang' => $nilaiCabang,
        ];

        // 2. Data Transaksi Terbaru
        $transaksiTerbaruQuery = Transaksi::with(['cabang', 'user', 'detailTransaksis.produk']);
        if (!$isSuper) {
            $transaksiTerbaruQuery->where('id_cabang', $id_cabang);
        }
        $transaksi_terbaru = $transaksiTerbaruQuery->orderBy('tanggal_transaksi', 'desc')
            ->take(5)
            ->get();

        // 3. Data Bar Chart (Penjualan 7 Hari Terakhir)
        $barChartData = [];
        $barChartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $barChartLabels[] = $date->format('d M');
            
            $chartQuery = Transaksi::whereDate('tanggal_transaksi', $date);
            if (!$isSuper) {
                $chartQuery->where('id_cabang', $id_cabang);
            }
            $barChartData[] = $chartQuery->sum('total_harga');
        }

        // 4. Data Donut Chart (Kontribusi Cabang) - Hanya untuk Super Admin
        $donutChartData = [];
        $donutChartLabels = [];
        $colorsToPass = [];
        $totalPendapatanGlobal = 0;

        if ($isSuper) {
            $cabangs = Cabang::all();
            $donutChartColors = ['#1a5ca6', '#6366f1', '#92400e', '#10b981', '#f59e0b', '#ef4444'];

            foreach ($cabangs as $index => $cbg) {
                $totalPendapatan = Transaksi::where('id_cabang', $cbg->id_cabang)->sum('total_harga');
                $donutChartData[] = (float) $totalPendapatan;
                $donutChartLabels[] = $cbg->nama_cabang;
                $colorsToPass[] = $donutChartColors[$index % count($donutChartColors)];
            }
            $totalPendapatanGlobal = array_sum($donutChartData);
        }

        // 5. Data Perubahan Harga Beli (Khusus Super Admin)
        $perubahan_harga = [];
        if ($isSuper) {
            $perubahan_harga = \App\Models\LogPerubahanHarga::with(['produk', 'user'])
                ->orderBy('tanggal', 'desc')
                ->take(5)
                ->get();
        }

        return view('admin.dashboard', compact(
            'statistik', 
            'transaksi_terbaru',
            'barChartData',
            'barChartLabels',
            'donutChartData',
            'donutChartLabels',
            'colorsToPass',
            'totalPendapatanGlobal',
            'perubahan_harga'
        ));
    }
}
