<?php

namespace App\Repositories;

use App\Models\Shift;
use App\Models\Transaksi;
use App\Models\KasKeluar;
use Carbon\Carbon;
use Exception;

class ShiftRepository
{
    /**
     * Mengambil shift aktif dan riwayat shift berdasarkan bulan & tahun.
     */
    public function getHalamanShift($user, $bulan = null, $tahun = null)
    {
        $id_cabang = $user->id_cabang;
        $bulan = $bulan ?? date('m');
        $tahun = $tahun ?? date('Y');

        // 1. Ambil Shift Aktif milik user yang sedang login
        // Setiap kasir hanya melihat shift-nya sendiri
        $shiftAktif = Shift::with('user:id_user,name')
            ->where('id_user', $user->id_user)
            ->where('status', 'buka')
            ->first();

        $dataShiftAktif = null;
        if ($shiftAktif) {
            $dataShiftAktif = [
                'id_shift'      => $shiftAktif->id_shift,
                'status'        => 'Shift Aktif',
                'dimulai_sejak' => Carbon::parse($shiftAktif->waktu_buka)->format('H:i') . ' WIB',
                'kasir'         => $shiftAktif->user->name ?? 'Admin',
                'saldo_awal'    => $shiftAktif->saldo_awal
            ];
        }

        // 2. Ambil Riwayat Shift Selesai milik user yang sedang login
        $riwayatShift = Shift::with('user:id_user,name')
            ->where('id_user', $user->id_user)
            ->where('status', 'tutup')
            ->whereMonth('waktu_tutup', $bulan)
            ->whereYear('waktu_tutup', $tahun)
            ->orderBy('waktu_tutup', 'desc')
            ->get()
            ->map(function ($shift) {
                return [
                    'id_shift' => $shift->id_shift,
                    'tanggal' => Carbon::parse($shift->waktu_tutup)->translatedFormat('d F Y'),
                    'status' => 'SELESAI',
                    'saldo_awal' => $shift->saldo_awal,
                    'saldo_akhir' => $shift->saldo_akhir,
                    'kasir' => $shift->user->name ?? 'Admin'
                ];
            });

        // 3. Ambil Saldo Akhir dari shift cabang ini yang terakhir kali tutup (untuk modal awal otomatis)
        $shiftCabangTerakhir = Shift::where('id_cabang', $id_cabang)
            ->where('status', 'tutup')
            ->orderBy('waktu_tutup', 'desc')
            ->first();
        
        $saldoAkhirShiftSebelumnya = $shiftCabangTerakhir ? $shiftCabangTerakhir->saldo_akhir : 0;

        return [
            'shift_aktif' => $dataShiftAktif,
            'riwayat_shift' => $riwayatShift,
            'saldo_akhir_shift_sebelumnya' => $saldoAkhirShiftSebelumnya
        ];
    }

    /**
     * Membuka shift baru untuk user yang sedang login.
     */
    public function bukaShift($user, $saldo_awal)
    {
        // Cek apakah kasir ini (atau cabang ini) masih punya shift aktif
        // Biasanya sistem kasir mengizinkan 1 kasir 1 shift aktif, atau 1 cabang 1 shift aktif.
        // Kita asumsikan 1 kasir hanya boleh 1 shift aktif.
        $cekShiftKasir = Shift::where('id_user', $user->id_user)
            ->where('status', 'buka')
            ->exists();

        if ($cekShiftKasir) {
            throw new Exception("Anda masih memiliki shift yang sedang berjalan. Tutup shift sebelumnya terlebih dahulu.");
        }

        return Shift::create([
            'id_user' => $user->id_user,
            'id_cabang' => $user->id_cabang,
            'saldo_awal' => $saldo_awal,
            'waktu_buka' => now(),
            'status' => 'buka'
        ]);
    }

    /**
     * Mengambil ringkasan data shift yang akan ditutup.
     */
    public function getRingkasanTutupShift($user)
    {
        $shiftAktif = Shift::with('user:id_user,name')->where('id_user', $user->id_user)
            ->where('status', 'buka')
            ->first();

        if (!$shiftAktif) {
            throw new Exception("Tidak ada shift aktif untuk melihat ringkasan penutupan.");
        }

        $totalPenjualan = Transaksi::where('id_shift', $shiftAktif->id_shift)->sum('total_harga');
        $totalKasKeluar = KasKeluar::where('id_shift', $shiftAktif->id_shift)->sum('jumlah_pengeluaran');
        
        // Kalkulasi Saldo Akhir Sistem
        $saldoAkhirSistem = $shiftAktif->saldo_awal + $totalPenjualan - $totalKasKeluar;

        return [
            'id_shift_formatted' => '#SHF-' . $shiftAktif->id_shift . date('Ymd', strtotime($shiftAktif->waktu_buka)),
            'waktu_mulai' => Carbon::parse($shiftAktif->waktu_buka)->format('H:i') . ' WIB',
            'kasir' => $shiftAktif->user->name ?? 'Admin',
            'saldo_awal' => $shiftAktif->saldo_awal,
            'total_penjualan_terhitung' => $totalPenjualan,
            'estimasi_saldo_akhir' => $saldoAkhirSistem
        ];
    }

    /**
     * Menutup shift aktif milik user yang sedang login dengan pencatatan selisih.
     */
    public function tutupShift($user, $data)
    {
        $shiftAktif = Shift::where('id_user', $user->id_user)
            ->where('status', 'buka')
            ->first();

        if (!$shiftAktif) {
            throw new Exception("Tidak ada shift aktif yang bisa ditutup.");
        }

        // Hitung Saldo Akhir Sistem
        $totalPenjualan = Transaksi::where('id_shift', $shiftAktif->id_shift)->sum('total_harga');
        $totalKasKeluar = KasKeluar::where('id_shift', $shiftAktif->id_shift)->sum('jumlah_pengeluaran');
        $saldoAkhirSistem = $shiftAktif->saldo_awal + $totalPenjualan - $totalKasKeluar;

        // Ambil Inputan Aktual Kasir
        $uangFisikTunai = $data['uang_fisik_tunai'];
        $detailChannel = $data['detail_channel'] ?? [];

        // Hitung total nominal di channel (BRI, BNI, dll)
        $totalNominalChannel = 0;
        foreach ($detailChannel as $channel => $nominal) {
            $totalNominalChannel += (float) $nominal;
        }

        // Hitung Selisih
        // Rumus: (uang_fisik + total_channel) - saldo_sistem
        $selisih = ($uangFisikTunai + $totalNominalChannel) - $saldoAkhirSistem;

        // Saldo akhir aktual yang di-store
        $saldoAkhirAktual = $uangFisikTunai + $totalNominalChannel;

        $shiftAktif->update([
            'waktu_tutup' => now(),
            'saldo_akhir_sistem' => $saldoAkhirSistem,
            'uang_fisik_tunai' => $uangFisikTunai,
            'detail_channel' => $detailChannel,
            'saldo_akhir' => $saldoAkhirAktual,
            'selisih' => $selisih,
            'status' => 'tutup'
        ]);

        return $shiftAktif;
    }
}
