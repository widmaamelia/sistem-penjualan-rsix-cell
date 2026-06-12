<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabangUtama = \App\Models\Cabang::first();

        // Riwayat 24 Mei 2024
        $userBudi = \App\Models\User::firstOrCreate(
            ['email' => 'budi@rsixcell.com'],
            [
                'id_cabang' => $cabangUtama->id_cabang,
                'name' => 'Budi Santoso',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'karyawan',
                'status' => 'aktif',
            ]
        );

        \App\Models\Shift::create([
            'id_user' => $userBudi->id_user,
            'id_cabang' => $cabangUtama->id_cabang,
            'saldo_awal' => 500000,
            'saldo_akhir' => 2450000,
            'waktu_buka' => '2024-05-24 08:00:00',
            'waktu_tutup' => '2024-05-24 16:00:00',
            'status' => 'tutup'
        ]);

        // Riwayat 23 Mei 2024
        $userAni = \App\Models\User::firstOrCreate(
            ['email' => 'ani@rsixcell.com'],
            [
                'id_cabang' => $cabangUtama->id_cabang,
                'name' => 'Ani Wijaya',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'karyawan',
                'status' => 'aktif',
            ]
        );

        \App\Models\Shift::create([
            'id_user' => $userAni->id_user,
            'id_cabang' => $cabangUtama->id_cabang,
            'saldo_awal' => 500000,
            'saldo_akhir' => 1890500,
            'waktu_buka' => '2024-05-23 08:00:00',
            'waktu_tutup' => '2024-05-23 16:00:00',
            'status' => 'tutup'
        ]);
    }
}
