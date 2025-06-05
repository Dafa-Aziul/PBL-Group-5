<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenisKendaraan>
 */
class JenisKendaraanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_jenis' => $this->faker->word,  // Nama jenis kendaraan, misalnya: "Mobil"
            'tipe_kendaraan' => $this->faker->word, // Tipe kendaraan, misalnya: "SUV"
            'deskripsi' => $this->faker->paragraph, // Deskripsi kendaraan
        ];
    }
}
