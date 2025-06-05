<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ServiceForm extends Form
{

    #[Validate('required|exists:kendaraans,id')]
    public ?int $kendaraan_id = null;

    #[Validate('required|exists:karyawans,id')]
    public ?int $montir_id = null;

    #[Validate('required|numeric')]
    public ?int $odometer = null;

    #[Validate('required|string')]
    public ?string $deskripsi_keluhan = null;

    #[Validate('nullable|in:dalam antrian,dianalisis,analisis selesai,dalam proses,selesai,batal')]
    public ?string $status = 'dalam antrian';

    #[Validate('nullable|date')]
    public ?string $tanggal_mulai_service = null;

    #[Validate('nullable|string')]
    public ?string $keterangan = null;

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
