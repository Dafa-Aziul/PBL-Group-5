<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class JenisKendaraanForm extends Form
{
    #[Validate('required|string|max:255')]
    public $nama_jenis = '';
    #[Validate('required|string|max:255')]
    public $model_kendaraan = '';
    #[Validate('required|string|max:255')]
    public $deskripsi = '';
    
    public function fillFromModel($jenisKendaraan)
    {
        $this->nama_jenis = $jenisKendaraan->nama_jenis;
        $this->model_kendaraan = $jenisKendaraan->model_kendaraan;
        $this->deskripsi = $jenisKendaraan->deskripsi;
    }
}
