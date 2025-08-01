<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class KontenForm extends Form
{
    #[Validate('required|string|max:150')]
    public $judul = '';

    #[Validate('required|string|max:50')]
    public $kategori = '';

    #[Validate('required')]
    public $isi = '';

    #[Validate('nullable|image|max:5120')]
    public $foto_konten;

    #[Validate('nullable|mimes:mp4,mov,avi|max:10000')]
    public $video_konten;

    #[Validate('required|string|in:draft,terbit,arsip')]
    public $status;

    public $gambar_lama = null ;
    public $video_lama = null ;


    public function fillFromModel($konten)
    {
        $this->judul = $konten->judul ?? '';
        $this->kategori = $konten->kategori ?? '';
        $this->isi = $konten->isi ?? '';
        $this->status = $konten->status?? '';

        // Jangan isi properti upload file langsung,
        // tapi simpan nama file gambar/video lama jika perlu
        $this->gambar_lama = $konten->foto_konten ?? null;
        $this->video_lama = $konten->video_konten ?? null;
    }
}
