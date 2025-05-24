<?php

namespace App\Livewire\Service;

use App\Livewire\Forms\ServiceForm;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Service;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Carbon\Carbon;

class Create extends Component
{
    public ServiceForm $form;
    #[Validate('required|unique:services,kode_service')]
    public $kode_service;
    #[Validate('required|exists:pelanggans,id')]
    public $pelanggan_id;

    public $pelanggans = [];
    public $montirs = [];

    public $selectedKendaraan;

    public function mount()
    {
        $this->pelanggans = Pelanggan::all();
        $this->montirs = Karyawan::where('jabatan', 'mekanik')->get();
    }

    public function getKendaraansProperty()
    {
        return $this->pelanggan_id
            ? Kendaraan::where('pelanggan_id', $this->pelanggan_id)->get()
            : collect();
    }

    public function updatedFormKendaraanId($value)
    {
        $this->selectedKendaraan = Kendaraan::find($value);
    }


    public function store()
    {
        $this->validate();

        $validated = $this->form->validate();

        // Cek apakah kendaraan terpilih ada
        if (!$this->selectedKendaraan) {
            session()->flash('error', 'Pilih kendaraan terlebih dahulu!');
            return;
        }

        // Gabungkan data dari kode_service, validasi form, dan data kendaraan
        $data = array_merge($validated, [
            'kode_service' => $this->kode_service,
            'no_polisi' => $this->selectedKendaraan->no_polisi,
            'model_kendaraan' => $this->selectedKendaraan->model_kendaraan,
            'tanggal_mulai_service' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ]);

        Service::create($data);

        session()->flash('success', 'Data service berhasil disimpan!');

        return redirect()->route('service.view');
    }


    public function render()
    {
        // $montirs = Karyawan::where('jabatan','mekanik')->get();
        // dd($montirs);
        return view('livewire.service.create', [
            'kendaraans' => $this->kendaraans,
        ]);
    }
}
