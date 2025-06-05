<?php

namespace Database\Seeders;

use App\Models\Sparepart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SparepartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $spareparts = [
            [
                'kode' => 'SP001',
                'nama' => 'Kampas Rem',
                'merk' => 'Brembo',
                'satuan' => 'Set',
                'stok' => 50,
                'harga' => 120000,
                'tipe_kendaraan' => 'Honda Beat',
                'foto' => null,
                'ket' => 'Kampas rem depan'
            ],
            [
                'kode' => 'SP002',
                'nama' => 'Busi',
                'merk' => 'NGK',
                'satuan' => 'Pcs',
                'stok' => 100,
                'harga' => 30000,
                'tipe_kendaraan' => 'Yamaha Mio',
                'foto' => null,
                'ket' => 'Busi standar motor bebek'
            ],
            [
                'kode' => 'SP003',
                'nama' => 'Oli Mesin',
                'merk' => 'Shell Advance',
                'satuan' => 'Botol',
                'stok' => 75,
                'harga' => 45000,
                'tipe_kendaraan' => 'Umum',
                'foto' => null,
                'ket' => 'Oli mesin 10W-40 untuk motor harian'
            ],
        ];

        foreach ($spareparts as $item) {
            Sparepart::create($item);
        }
    }
}
