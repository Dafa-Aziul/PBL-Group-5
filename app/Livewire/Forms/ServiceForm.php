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

    #[Validate('nullable|in:dalam antrian,dianalisis,analisis selesai,dalam proses,selesai,batal')]
    public $status = 'dalam antrian';


    // #[Validate('nullable|numeric')]
    // public $estimasi_harga;

    #[Validate('nullable|date')]
    public $tanggal_mulai_service;

    #[Validate('nullable|string')]
    public $keterangan;

    public function fillFormModel($service)
    {
        // $this->kode = $sparepart->kode;
        $this->kendaraan_id = $service->kendaraan_id;
        $this->montir_id = $service->montir_id;
        $this->odometer = $service->odometer;
        $this->deskripsi_keluhan = $service->deskripsi_keluhan;
        $this->tanggal_mulai_service = $service->tanggal_mulai_service;
        $this->status = $service->status;
        $this->keterangan = $service->keterangan;
        // $this-> = $service->ket;
        // $this->foto_lama = $service->foto;
    }
}
