<?php

namespace Database\Factories;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AbsensiFactory extends Factory
{
    protected $model = Absensi::class;

    public function definition(): array
    {
        $jamMasuk = $this->faker->dateTimeBetween('08:00:00', '09:00:00');
        $jamKeluar = $this->faker->dateTimeBetween('16:00:00', '19:00:00');
        $statusList = ['hadir', 'terlambat', 'lembur', 'alpha', 'sakit', 'izin'];
        $status = $this->faker->randomElement($statusList);

        return [
            'tanggal' => $this->faker->dateTimeBetween('-60 days', 'now')->format('Y-m-d'),
            'jam_masuk' => $jamMasuk->format('H:i'),
            'jam_keluar' => $jamKeluar->format('H:i'),
            'status' => $status,
            'keterangan' => $this->faker->sentence(),
            'foto_masuk' => 'absensi/foto_masuk/default.png',
            'foto_keluar' => 'absensi/foto_keluar/default.png',
        ];
    }
}
