<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class KendaraanForm extends Form
{
    #[Validate('required|exists:jenis_kendaraans,id')]
    public $jenis_kendaraan_id = '';

    #[Validate('required|string|max:20|unique:kendaraans,no_polisi')]
    public $no_polisi = '';

    #[Validate('required|string|max:50')]
    public $model_kendaraan = '';

    #[Validate('required|integer|min:0')]
    public $odometer = '';

    public function resetForm()
    {
        $this->jenis_kendaraan_id = '';
        $this->no_polisi = '';
        $this->model_kendaraan = '';
        $this->odometer = '';
    }
    public function simpan($pelanggan)
    {
        $this->validate();

        $kendaraan = $pelanggan->kendaraans()->create([
            'jenis_kendaraan_id' => $this->jenis_kendaraan_id,
            'no_polisi' => $this->no_polisi,
            'model_kendaraan' => $this->model_kendaraan,
            'odometer' => $this->odometer,
        ]);

        return $kendaraan;
    }
}
