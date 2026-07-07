<?php

namespace App\Repositories;

use App\Models\Shift;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    /**
     * Get all dashboard data for a specific user and their branch.
     */
    public function getDashboardData($user)
    {
        $id_cabang = $user->id_cabang;

        // 1. Shift Aktif User
        $activeShift = Shift::where('id_user', $user->id_user)
            ->where('status', 'buka')
            ->first();

        $shiftName = '-';
        $shiftStatus = 'Tidak Aktif';
        
        if ($activeShift) {
            $shiftStatus = 'Aktif';
            $hour = Carbon::parse($activeShift->waktu_buka)->hour;
            if ($hour >= 5 && $hour < 14) {
                $shiftName = 'Shift Pagi';
            } elseif ($hour >= 14 && $hour < 22) {
                $shiftName = 'Shift Siang';
            } else {
                $shiftName = 'Shift Malam';
            }
        }

        // 2. Statistik Hari Ini (berdasarkan cabang)
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Penjualan Hari Ini
        $penjualanHariIni = Transaksi::where('id_cabang', $id_cabang)
            ->whereDate('tanggal_transaksi', $today)
            ->sum('total_harga');

        // Penjualan Kemarin
        $penjualanKemarin = Transaksi::where('id_cabang', $id_cabang)
            ->whereDate('tanggal_transaksi', $yesterday)
            ->sum('total_harga');

        // Persentase vs Kemarin
        $persentaseVsKemarin = 0;
        if ($penjualanKemarin > 0) {
            $persentaseVsKemarin = (($penjualanHariIni - $penjualanKemarin) / $penjualanKemarin) * 100;
        } elseif ($penjualanHariIni > 0 && $penjualanKemarin == 0) {
            $persentaseVsKemarin = 100; // Jika kemarin 0 dan hari ini ada, anggap naik 100%
        }

        // Total Transaksi Hari Ini
        $totalTransaksi = Transaksi::where('id_cabang', $id_cabang)
            ->whereDate('tanggal_transaksi', $today)
            ->count();

        // Produk Terjual Hari Ini (Join dengan DetailTransaksi)
        $produkTerjual = DetailTransaksi::whereHas('transaksi', function ($query) use ($id_cabang, $today) {
                $query->where('id_cabang', $id_cabang)
                      ->whereDate('tanggal_transaksi', $today);
            })->sum('qty');

        // 3. Aktivitas Terbaru (3 transaksi terakhir di cabang ini)
        $aktivitasTerbaru = Transaksi::where('id_cabang', $id_cabang)
            ->orderBy('tanggal_transaksi', 'desc')
            ->take(3)
            ->get()
            ->map(function ($trx) {
                return [
                    'no_transaksi' => $trx->no_transaksi,
                    'metode_bayar' => ucfirst($trx->metode_bayar),
                    'waktu' => Carbon::parse($trx->tanggal_transaksi)->format('H:i') . ' WIB',
                    'total' => $trx->total_harga
                ];
            });

        return [
            'cabang' => [
                'nama' => $user->cabang ? $user->cabang->nama_cabang : 'Semua Cabang',
                'lokasi' => $user->cabang ? $user->cabang->alamat : '-'
            ],
            'user' => [
                'nama' => $user->name,
                'shift_aktif' => [
                    'nama_shift' => $shiftName,
                    'status' => $shiftStatus
                ]
            ],
            'statistik' => [
                'penjualan_hari_ini' => $penjualanHariIni,
                'persentase_vs_kemarin' => round($persentaseVsKemarin, 1),
                'total_transaksi' => $totalTransaksi,
                'produk_terjual' => $produkTerjual
            ],
            'menu_cepat' => [
                [
                    'label' => 'Stok',
                    'icon' => 'box',
                    'route' => '/stok'
                ],
                [
                    'label' => 'Kas Keluar',
                    'icon' => 'wallet',
                    'route' => '/kas-keluar'
                ]
            ],
            'aktivitas_terbaru' => $aktivitasTerbaru
        ];
    }
}
