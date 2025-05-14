<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class JenisKendaraanForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $nama_jenis = '';
    #[Validate('required|string|max:255')]
    public string $tipe_kendaraan = '';
    #[Validate('required|string|max:255')]
    public string $deskripsi = '';

    public function fillFormModel($jenisKendaraan)
    {
        $this->nama_jenis = $jenisKendaraan->nama_jenis;
        $this->tipe_kendaraan = $jenisKendaraan->tipe_kendaraan;
        $this->deskripsi = $jenisKendaraan->deskripsi;
    }
}
