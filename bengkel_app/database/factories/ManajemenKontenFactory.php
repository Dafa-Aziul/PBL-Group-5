<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ManajemenKonten;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ManajemenKonten>
 */
class ManajemenKontenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul'         => $this->faker->sentence,
            'isi'           => $this->faker->paragraph,
            'kategori'      => $this->faker->word,
            'tanggal_terbit'=> $this->faker->date,
            'gambar'        => null,
            'video'         => null,
            'status'        => $this->faker->randomElement(['draft', 'terbit', 'arsip']),
            'penulis'       => $this->faker->name,
        ];
    }
}
