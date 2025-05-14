<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SparepartForm extends Form
{

    #[Validate('required|string|max:255')]
    public string $nama = '';

    #[Validate('required|string|max:255')]
    public string $merk = '';

    #[Validate('required|string|max:255')]
    public string $satuan = '';

    #[Validate('required|integer|min:0')]
    public int $stok = 0;

    #[Validate('required|numeric|min:0')]
    public float $harga = 0.0;

    #[Validate('required|string|max:255')]
    public string $model_kendaraan = '';

    #[Validate('required|string|max:255')]
    public string $ket = '';

    public function fillFormModel($sparepart)
    {
        // $this->kode = $sparepart->kode;
        $this->nama = $sparepart->nama;
        $this->merk = $sparepart->merk;
        $this->satuan = $sparepart->satuan;
        $this->stok = $sparepart->stok;
        $this->harga = $sparepart->harga;
        $this->model_kendaraan = $sparepart->model_kendaraan;
        $this->ket = $sparepart->ket;
    }


}
