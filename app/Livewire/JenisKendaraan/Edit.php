<?php

namespace App\Livewire\JenisKendaraan;

use App\Livewire\Forms\JenisKendaraanForm;
use App\Models\JenisKendaraan;
use Livewire\Component;

class Edit extends Component
{
    public $jenis_kendaraan;
    public JenisKendaraanForm $form;

    public function mount($id)
    {
        $this->jenis_kendaraan = JenisKendaraan::findOrFail($id);
        $this->form->fillFormModel($this->jenis_kendaraan);
    }
    
    public function update()
    {
        $validated = $this->form->validate();
        $this->jenis_kendaraan->update($validated);

        return redirect()->route('jenis_kendaraan.view')->with('succes','Data berhasil diperbarui');
    }
    public function render()
    {
        return view('livewire.jenis-kendaraan.edit', [
            'jenis_kendaraan' => $this->jenis_kendaraan
        ]);
    }
}
