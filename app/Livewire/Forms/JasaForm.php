<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class JasaForm extends Form
{
    #[Validate('required|integer|exists:jenis_kendaraans,id')]
    public int $jenis_kendaraan_id;

    #[Validate('required|string|max:255')]
    public string $kode = '';

    #[Validate('required|string|max:255')]
    public string $nama_jasa = '';

    #[Validate('required|string|max:255')]
    public string $estimasi = '';

    #[Validate('required|numeric|min:0')]
    public float $harga;

    #[Validate('required|string|max:255')]
    public string $keterangan = '';

    public function fillFormModel($jasa)
    {
        $this->jenis_kendaraan_id = $jasa->jenis_kendaraan_id;
        $this->kode = $jasa->kode;
        $this->nama_jasa = $jasa->nama_jasa;
        $this->estimasi = $jasa->estimasi;
        $this->harga = $jasa->harga;
        $this->keterangan = $jasa->keterangan;
    }

}
