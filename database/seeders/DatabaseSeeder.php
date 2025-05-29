<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\JenisKendaraan;
use App\Models\Pelanggan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);
        User::factory(1)->create([
            'role' => 'owner',
        ]);
        User::factory(2)->create([
            'role' => 'admin',
        ]);
        User::factory(15)->create([
            'role' => 'mekanik',
        ]);

        JenisKendaraan::factory(10)->create();

        Pelanggan::factory(10)->create();

        $karyawans = Karyawan::all();

        foreach ($karyawans as $karyawan) {
            Absensi::factory()->count(5)->create([
                'karyawan_id' => $karyawan->id,
            ]);
        }


        $this->call(SparepartsSeeder::class);
        $this->call(JasasSeeder::class);
    }
}