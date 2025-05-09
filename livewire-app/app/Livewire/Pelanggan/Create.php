<?php

namespace App\Livewire\Pelanggan;

use Livewire\Component;
use App\Models\Pelanggan;

class Create extends Component
{
    public $nama_pelanggan, $email, $no_telp, $alamat, $no_polisi, $jenis_kendaraan, $model, $ket;

    protected $rules = [
        'nama_pelanggan' => 'required|string|max:255',
        'email' => 'required|email|unique:pelanggans,email',
        'no_telp' => 'required|string|max:15',
        'alamat' => 'required|string',
        'no_polisi' => 'required|string|max:20',
        'jenis_kendaraan' => 'required|in:Mobil,Truk,Pick Up,Bus,Minibus',
        'model' => 'required|string|max:50',
        'ket' => 'required|in:Pribadi,Perusahaan',
    ];

    public function simpan()
    {
        $this->validate();

        Pelanggan::create($this->only(array_keys($this->rules)));

        session()->flash('success', 'Data berhasil disimpan.');

        $this->reset();
    }
 
    public function render()
    {
        return view('livewire.pelanggan.create');
    }
}
