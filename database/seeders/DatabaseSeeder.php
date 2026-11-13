<?php

namespace Database\Seeders;

use App\Models\Antrian;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@antrian.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin1234'),
            ]
        );

        $k1 = Kendaraan::firstOrCreate(
            ['nomor_polisi' => 'B 1234 ABC'],
            [
                'user_id' => $user->id,
                'jenis_kendaraan' => 'Mobil',
                'nama_pemilik' => 'Ahmad Fauzi',
            ]
        );

        $k2 = Kendaraan::firstOrCreate(
            ['nomor_polisi' => 'B 5678 XYZ'],
            [
                'user_id' => $user->id,
                'jenis_kendaraan' => 'Motor',
                'nama_pemilik' => 'Siti Aminah',
            ]
        );

        $k3 = Kendaraan::firstOrCreate(
            ['nomor_polisi' => 'D 9012 EFG'],
            [
                'user_id' => $user->id,
                'jenis_kendaraan' => 'Truk',
                'nama_pemilik' => 'Budi Santoso',
            ]
        );

        $today = date('Y-m-d');

        Antrian::firstOrCreate(
            ['nomor_antrian' => 'A001', 'tanggal' => $today],
            [
                'kendaraan_id' => $k1->id,
                'waktu' => '08:30:00',
                'status' => 'Selesai',
            ]
        );

        Antrian::firstOrCreate(
            ['nomor_antrian' => 'A002', 'tanggal' => $today],
            [
                'kendaraan_id' => $k2->id,
                'waktu' => '09:15:00',
                'status' => 'Diproses',
            ]
        );

        Antrian::firstOrCreate(
            ['nomor_antrian' => 'A003', 'tanggal' => $today],
            [
                'kendaraan_id' => $k3->id,
                'waktu' => '10:00:00',
                'status' => 'Menunggu',
            ]
        );
    }
}
