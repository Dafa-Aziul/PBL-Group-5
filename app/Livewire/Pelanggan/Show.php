<?php

namespace App\Livewire\Pelanggan;

use App\Livewire\Forms\KendaraanForm;
use App\Models\JenisKendaraan;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Detail Data Pelanggan')]
class Show extends Component
{
    public $id;
    public $jenis_kendaraans;
    public KendaraanForm $form;

    public function mount($id)
    {
        $this->jenis_kendaraans = JenisKendaraan::all();
        $this->id = $id;
    }

    public function closeModal(){
        $this->dispatch('hide-modal');
    }

    public function createKendaraan()
    {
        $this->form->validate();

        $pelanggan = Pelanggan::findOrFail($this->id);

        $this->form->simpan($pelanggan);
        session()->flash('success', 'Kendaraan berhasil ditambahkan!');
        $this->form->resetForm();
        $this->closeModal();
    }
    public function render()
    {
        $pelanggan = Pelanggan::findOrFail($this->id);
        return view('livewire.pelanggan.show', compact('pelanggan'));
    }
}
