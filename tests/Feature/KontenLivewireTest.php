<?php

namespace Tests\Feature;

use App\Livewire\Konten\Create;
use App\Livewire\Konten\Edit;
use App\Models\Konten;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KontenLivewireTest extends TestCase
{

    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function form_validasi_konten_gagal_jika_kosong()
    {
        Livewire::test(Create::class)
            ->set('form.judul', '')
            ->set('form.kategori', '')
            ->set('form.isi', '')
            ->call('submit')
            ->assertHasErrors(['form.judul', 'form.kategori', 'form.isi']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function upload_file_gambar_dan_video_berhasil_disimpan()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(Create::class)
            ->set('form.judul', 'Test Upload')
            ->set('form.kategori', 'Berita')
            ->set('form.isi', 'Isi konten...')
            ->set('form.foto_konten', UploadedFile::fake()->image('gambar.jpg'))
            ->set('form.video_konten', UploadedFile::fake()->create('video.mp4'))
            ->set('form.status', 'terbit')
            ->call('submit');


        $konten = Konten::first();
        $this->assertNotNull($konten, 'Konten tidak berhasil disimpan ke database');

        $this->assertTrue(Storage::disk('public')->exists('konten/gambar/' . $konten->foto_konten));
        $this->assertTrue(Storage::disk('public')->exists('konten/video/' . $konten->video_konten));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function update_konten_berhasil_dan_hapus_file_lama()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $konten = Konten::factory()->create([
            'judul' => 'Awal',
            'kategori' => 'Umum',
            'isi' => 'Isi awal',
            'foto_konten' => 'lama.jpg',
            'video_konten' => 'lama.mp4',
            'penulis_id' => $user->id,
        ]);

        Storage::disk('public')->put('konten/gambar/lama.jpg', 'isi');
        Storage::disk('public')->put('konten/video/lama.mp4', 'isi');

        Livewire::test(Edit::class, ['id' => $konten->id])
            ->set('form.judul', 'Update')
            ->set('form.kategori', 'Update')
            ->set('form.isi', 'Isi baru')
            ->set('form.gambar_lama', 'lama.jpg')
            ->set('form.video_lama', 'lama.mp4')
            ->set('form.foto_konten', UploadedFile::fake()->image('baru.jpg'))
            ->set('form.video_konten', UploadedFile::fake()->create('baru.mp4'))
            ->call('update');

        $konten->refresh();

        $this->assertFalse(Storage::disk('public')->exists('konten/gambar/lama.jpg'), 'Gambar lama masih ada di storage');
        $this->assertFalse(Storage::disk('public')->exists('konten/video/lama.mp4'), 'Video lama masih ada di storage');
        $this->assertTrue(Storage::disk('public')->exists('konten/gambar/' . $konten->foto_konten), 'Gambar baru tidak ditemukan');
        $this->assertTrue(Storage::disk('public')->exists('konten/video/' . $konten->video_konten), 'Video baru tidak ditemukan');
    }
}
