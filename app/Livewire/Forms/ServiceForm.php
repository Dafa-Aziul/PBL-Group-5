<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ServiceForm extends Form
{
    // #[Validate('required|exists:pelanggans,id')]
    // public $pelanggan_id;

    #[Validate('required|exists:kendaraans,id')]
    public $kendaraan_id;

    #[Validate('required|exists:karyawans,id')]
    public $montir_id;

    #[Validate('required|numeric')]
    public $odometer;

    #[Validate('required|string')]
    public $deskripsi_keluhan;

    // #[Validate('required|in:dalam antrian,dianalisis,analisis selesai,dalam proses,selesai,batal')]
    // public $status;


    // #[Validate('nullable|numeric')]
    // public $estimasi_harga;

    #[Validate('nullable|date')]
    public $tanggal_mulai_service;

    #[Validate('nullable|string')]
    public $keterangan;
}
