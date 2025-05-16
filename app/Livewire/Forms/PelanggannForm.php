<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PelanggannForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $nama = '';

    #[Validate('required|string|max:15')]
    public string $no_hp = '';

    #[Validate('required|string|max:255')]
    public string $alamat = '';

    #[Validate('required|in:pribadi,perusahaan')]
    public string $keterangan = '   ';

    public function fillFromModel($pelanggan)
    {
        $this->nama = $pelanggan->nama;
        $this->no_hp = $pelanggan->no_hp;
        $this->keterangan= $pelanggan->keterangan;
        $this->alamat = $pelanggan->alamat;
    }
}
