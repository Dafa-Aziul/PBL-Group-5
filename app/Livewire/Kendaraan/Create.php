<?php

namespace App\Livewire\Kendaraan;

use App\Livewire\Forms\KendaraanForm;
use App\Models\JenisKendaraan;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required')]
    public $pelanggan_id;
    public $pelanggan;
    public $jenis_kendaraans;
    public KendaraanForm $form;
    public function mount($id)
    {
        $this->pelanggan_id = $id;
        $this->pelanggan = Pelanggan::findOrFail($id);
        $this->jenis_kendaraans = JenisKendaraan::all();
    }
    public function submit()
    {
        $data = $this->form->validate();
        $data['pelanggan_id'] = $this->pelanggan_id;
        Kendaraan::create($data);
        session()->flash('success', 'Kendaraan berhasil ditambahkan!');
        return redirect()->route('pelanggan.detail', ['id' => $this->pelanggan_id]);
    }
    public function render()
    {
        $jenis_kendaraans = JenisKendaraan::all();
        $pelanggan = Pelanggan::findOrFail($this->pelanggan_id);
        return view('livewire.kendaraan.create', compact('jenis_kendaraans', 'pelanggan'));
    }
}
