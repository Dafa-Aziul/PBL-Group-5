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
            'nama_jenis' => $this->faker->randomElement(['Truk Box', 'Truk Tangki', 'Truk Trailer']),
            'merk' => $this->faker->randomElement(['Hino', 'Fuso', 'Isuzu']),
            'model' => $this->faker->bothify('Model-###'),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
