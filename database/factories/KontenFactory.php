<?php

namespace Database\Factories;

use App\Models\Konten;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Konten>
 */
class KontenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Konten::class;
    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence(),
            'kategori' => $this->faker->randomElement(['Berita', 'Tutorial', 'Informasi']),
            'isi' => $this->faker->paragraph(3),
            'foto_konten' => 'dummy.jpg', // default dummy, ga usah upload beneran
            'video_konten' => 'dummy.mp4', // default dummy
            'penulis_id' => User::factory(), // auto bikin user juga
        ];
    }
}
