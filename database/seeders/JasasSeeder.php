<?php

namespace Database\Seeders;

use App\Models\Jasa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JasasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jasas = [
            [
                'jenis_kendaraan_id' => 1,
                'kode' => 'JS001',
                'nama_jasa' => 'Ganti Oli',
                'estimasi' => '00:30', // 30 menit
                'harga' => 25000,
                'keterangan' => 'Ganti oli mesin dengan oli standar'
            ],
            [
                'jenis_kendaraan_id' => 1,
                'kode' => 'JS002',
                'nama_jasa' => 'Tune Up',
                'estimasi' => '01:11', // 1 jam 11 menit
                'harga' => 100000,
                'keterangan' => 'Penyetelan ulang komponen mesin'
            ],
            [
                'jenis_kendaraan_id' => 2,
                'kode' => 'JS003',
                'nama_jasa' => 'Servis Rem',
                'estimasi' => '00:45',
                'harga' => 75000,
                'keterangan' => 'Pemeriksaan dan penggantian kampas rem'
            ],
        ];

        foreach ($jasas as $item) {
            Jasa::create($item);
        }
    }
}
