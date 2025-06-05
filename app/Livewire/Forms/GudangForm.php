<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class GudangForm extends Form
{

    #[Validate('required|in:masuk,keluar')]
    public ?string $aktivitas;

    #[Validate('required|integer|min:1')]
    public ?int $jumlah;

    #[Validate('nullable|string')]
    public ?string $keterangan;

    public function resetForm()
    {
        $this->aktivitas = null;
        $this->jumlah = null;
        $this->keterangan = '';
    }
    public function simpan($sparepart)
    {
        $this->validate();

        $gudang = $sparepart->gudangs()->create([
            'aktivitas' => $this->aktivitas,
            'jumlah' => $this->jumlah,
            'keterangan' => $this->keterangan,
        ]);

        return $gudang;
    }
}
