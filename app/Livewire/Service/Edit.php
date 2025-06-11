<?php

namespace App\Livewire\Service;

use App\Livewire\Forms\ServiceForm;
use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Service;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Memperbarui Data Service')]
class Edit extends Component
{
    #[Validate('required|exists:pelanggans,id')]
    public ServiceForm $form;
    public $service;
    public $pelanggan_id;
    public $pelanggans;
    public $kendaraan;
    public $montirs = [];

    public function mount($id)
    {
        $this->service = Service::findOrFail($id);
        $this->form->fillFormModel($this->service);
        $this->kendaraan = Kendaraan::findOrFail($this->form->kendaraan_id);
        $this->pelanggan_id = $this->kendaraan->pelanggan_id;
        $this->pelanggans = Pelanggan::all();
        $this->montirs = Karyawan::where('jabatan', 'mekanik')->get();
    }


    public function getKendaraansProperty()
    {
        return $this->pelanggan_id
            ? Kendaraan::where('pelanggan_id', $this->pelanggan_id)->get()
            : collect();
    }

    public function update()
    {
        $validated = $this->form->validate();
        $odometerLama = $this->kendaraan->odometer;

        // Validasi odometer baru tidak boleh lebih kecil
        if ($this->form->odometer < $odometerLama) {
            $this->addError('form.odometer', 'Odometer tidak boleh lebih kecil dari sebelumnya (' . $odometerLama . ' Km).');
            return;
        }
        $this->service->update($validated);
        $this->kendaraan->update(['odometer' => $validated['odometer']]);
        return redirect()->route('service.view')->with('success','Data berhasil diperbarui');
    }

    public function render()
    {
        return view('livewire.service.edit',[
            'kendaraans' => $this->kendaraans,
        ] );

    }
}
