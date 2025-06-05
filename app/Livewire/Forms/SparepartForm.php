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
    public ?float $harga = 0.0;

    #[Validate('required|string|max:255')]
    public string $tipe_kendaraan = '';

    // Properti untuk upload foto baru (nullable)
    #[Validate('nullable|image|mimes:jpg,jpeg,png|max:2048')]
    public $foto;

    // Properti untuk menyimpan nama file foto lama dari DB
    public $foto_lama = null;

    #[Validate('required|string|max:255')]
    public string $ket = '';

    public function fillFormModel($sparepart)
    {
        // $this->kode = $sparepart->kode;
        $this->nama = $sparepart->nama;
        $this->merk = $sparepart->merk;
        $this->satuan = $sparepart->satuan;
        $this->stok = $sparepart->stok;
        $this->harga = (float) ($sparepart->harga ?? 0);
        $this->tipe_kendaraan = $sparepart->tipe_kendaraan;
        $this->ket = $sparepart->ket;
        $this->foto_lama = $sparepart->foto;
    }


}
