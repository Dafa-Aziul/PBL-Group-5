<?php

namespace App\Livewire\Service;

use App\Livewire\Forms\ServiceForm;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Service;
use App\Models\StatusService;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;

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

        // Ambil odometer lama dari kendaraan
        $odometerLama = $this->selectedKendaraan->odometer;

        // Validasi odometer baru tidak boleh lebih kecil
        if ($this->form->odometer < $odometerLama) {
            $this->addError('form.odometer', 'Odometer tidak boleh lebih kecil dari sebelumnya (' . $odometerLama . ' Km).');
            return;
        }

        // Gabungkan data dari kode_service, validasi form, dan data kendaraan
        $data = array_merge($validated, [
            'kode_service' => $this->kode_service,
            'no_polisi' => $this->selectedKendaraan->no_polisi,
            'model_kendaraan' => $this->selectedKendaraan->model_kendaraan,
            'tanggal_mulai_service' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ]);

        $this->selectedKendaraan->update(['odometer' => $data['odometer']]);

        $service = Service::create($data);
        if ($service) {
            $namaMontir = $service->montir->nama ?? 'montir';

            $keterangan = match ($validated['status']) {
                'dalam antrian'     => 'Service telah masuk ke dalam antrian.',
                'dianalisis'        => 'Service sedang dalam proses analisis oleh ' . $namaMontir . '.',
                'analisis selesai'  => 'Analisis telah selesai dilakukan oleh ' . $namaMontir . '.',
                'dalam proses'      => 'Service sedang dikerjakan oleh ' . $namaMontir . '.',
                'selesai'           => 'Service telah selesai dan siap diambil.',
                'batal'             => 'Service dibatalkan oleh pelanggan atau admin.',
                default             => null,
            };

            StatusService::create([
                'service_id' => $service->id,
                'kode_service' => $service->kode_service,
                'status' => $validated['status'],
                'keterangan' => $keterangan,
                'changed_at' => Carbon::now('Asia/Jakarta'),
            ]);

            session()->flash('success', 'Status berhasil diperbarui.');
        } else {
            session()->flash('error', 'Gagal memperbarui status service.');
        }

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
