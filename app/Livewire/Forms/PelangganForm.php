<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PelangganForm extends Form
{
    #[Validate('required|string|max:255')]
    public string $nama = '';
    #[Validate('required|email|unique:pelanggans,email')]
    public string $email = '';
     #[Validate('required|string|max:255')]
    public string $no_hp = '';
    #[Validate('required|string')]
    public string $alamat = '';
    #[Validate('required|exists:jenis_kendaraans,id')]
    public string $jenis_kendaraan_id = '';
    #[Validate('required|string|max:50')]
    public string $tipe_kendaraan = '';
    #[Validate('required|integer|min:0')]
    public string $odometer = '';
    #[Validate('required|in:pribadi,perusahaan')]
    public string $keterangan = '';
}
