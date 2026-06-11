<?php

namespace App\Repositories;

use App\Models\KasKeluar;
use App\Models\Shift;
use Carbon\Carbon;
use Exception;

class KasKeluarRepository
{
    /**
     * Mengambil statistik dan riwayat kas keluar cabang untuk hari ini.
     */
    public function getHalamanKasKeluar($user)
    {
        $id_cabang = $user->id_cabang;
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // 1. Total Pengeluaran Hari Ini (di cabang user)
        $pengeluaranHariIni = KasKeluar::whereHas('shift', function($query) use ($id_cabang) {
                $query->where('id_cabang', $id_cabang);
            })
            ->whereDate('tanggal', $today)
            ->sum('jumlah_pengeluaran');

        // 2. Total Pengeluaran Kemarin (untuk perbandingan)
        $pengeluaranKemarin = KasKeluar::whereHas('shift', function($query) use ($id_cabang) {
                $query->where('id_cabang', $id_cabang);
            })
            ->whereDate('tanggal', $yesterday)
            ->sum('jumlah_pengeluaran');

        $persentaseVsKemarin = 0;
        $trendVsKemarin = 'sama dengan';
        if ($pengeluaranKemarin > 0) {
            $persentaseVsKemarin = (($pengeluaranHariIni - $pengeluaranKemarin) / $pengeluaranKemarin) * 100;
        } elseif ($pengeluaranHariIni > 0 && $pengeluaranKemarin == 0) {
            $persentaseVsKemarin = 100;
        }

        if ($persentaseVsKemarin > 0) {
            $trendVsKemarin = 'lebih tinggi dari';
        } elseif ($persentaseVsKemarin < 0) {
            $trendVsKemarin = 'lebih rendah dari';
        }

        $persentaseText = round(abs($persentaseVsKemarin), 1) . "% " . $trendVsKemarin . " kemarin";

        // 3. Aktivitas Kas Keluar Hari Ini (List)
        $aktivitasHariIni = KasKeluar::whereHas('shift', function($query) use ($id_cabang) {
                $query->where('id_cabang', $id_cabang);
            })
            ->whereDate('tanggal', $today)
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($kas) {
                return [
                    'id_kas_keluar' => $kas->id_kas_keluar,
                    'keterangan' => $kas->keterangan,
                    'jumlah_pengeluaran' => $kas->jumlah_pengeluaran,
                    'waktu' => Carbon::parse($kas->tanggal)->format('H:i') . ' WIB'
                ];
            });

        // 4. Laporan Mingguan Sederhana (Minggu ini vs Minggu lalu)
        $startThisWeek = Carbon::now()->startOfWeek();
        $startLastWeek = Carbon::now()->subWeek()->startOfWeek();
        $endLastWeek = Carbon::now()->subWeek()->endOfWeek();

        $pengeluaranMingguIni = KasKeluar::whereHas('shift', function($query) use ($id_cabang) {
                $query->where('id_cabang', $id_cabang);
            })->where('tanggal', '>=', $startThisWeek)->sum('jumlah_pengeluaran');

        $pengeluaranMingguLalu = KasKeluar::whereHas('shift', function($query) use ($id_cabang) {
                $query->where('id_cabang', $id_cabang);
            })->whereBetween('tanggal', [$startLastWeek, $endLastWeek])->sum('jumlah_pengeluaran');

        $persentaseMingguan = 0;
        if ($pengeluaranMingguLalu > 0) {
            $persentaseMingguan = (($pengeluaranMingguIni - $pengeluaranMingguLalu) / $pengeluaranMingguLalu) * 100;
        }

        $teksMingguan = "Pengeluaran minggu ini ";
        if ($persentaseMingguan < 0) {
            $teksMingguan .= "turun " . round(abs($persentaseMingguan), 1) . "% dibandingkan minggu lalu. Pertahankan efisiensi operasional Anda!";
        } elseif ($persentaseMingguan > 0) {
            $teksMingguan .= "naik " . round(abs($persentaseMingguan), 1) . "% dibandingkan minggu lalu. Harap perhatikan pembengkakan operasional.";
        } else {
            $teksMingguan .= "sama dengan minggu lalu.";
        }

        return [
            'header' => [
                'total_hari_ini' => $pengeluaranHariIni,
                'persentase_vs_kemarin_text' => $persentaseText
            ],
            'laporan_mingguan' => $teksMingguan,
            'aktivitas' => $aktivitasHariIni
        ];
    }

    /**
     * Tambah data kas keluar. Syarat: Harus ada shift aktif.
     */
    public function tambahKasKeluar($user, array $data)
    {
        // Cari shift yang masih buka untuk kasir ini
        $activeShift = Shift::where('id_user', $user->id_user)
            ->where('status', 'buka')
            ->first();

        if (!$activeShift) {
            throw new Exception("Anda tidak bisa mencatat kas keluar karena belum membuka shift (Shift tidak aktif).");
        }

        return KasKeluar::create([
            'id_shift' => $activeShift->id_shift,
            'jumlah_pengeluaran' => $data['jumlah_pengeluaran'],
            'keterangan' => $data['keterangan'],
            'tanggal' => now()
        ]);
    }
}
