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

        // 1. Data Statistik (Card)
        $pendapatanHariIni = Transaksi::whereDate('tanggal_transaksi', $today)->sum('total_harga');
        $totalTransaksiHariIni = Transaksi::whereDate('tanggal_transaksi', $today)->count();
        $cabangAktif = Cabang::where('status', 'aktif')->count();
        $totalCabang = Cabang::count();
        $karyawanBertugas = User::where('role', 'karyawan')->where('status', 'aktif')->count(); // Disederhanakan untuk contoh

        $statistik = [
            'pendapatan' => $pendapatanHariIni,
            'total_transaksi' => $totalTransaksiHariIni,
            'cabang_aktif' => "{$cabangAktif}/{$totalCabang}",
            'karyawan' => $karyawanBertugas,
        ];

        // 2. Data Transaksi Terbaru
        $transaksi_terbaru = Transaksi::with(['cabang', 'user', 'detailTransaksis'])
            ->orderBy('tanggal_transaksi', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('statistik', 'transaksi_terbaru'));
    }
}
