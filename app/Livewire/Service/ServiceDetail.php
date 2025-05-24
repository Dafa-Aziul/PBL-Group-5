<?php

namespace App\Livewire\Service;

use App\Models\Jasa;
use App\Models\Service;
use App\Models\ServiceJasa;
use App\Models\ServiceSparepart;
use App\Models\Sparepart;
use Livewire\Component;

class ServiceDetail extends Component
{
    public $service;
    public $jasas;          // semua jasa untuk select option
    public $spareparts;     // semua sparepart untuk select option

    // Data input sementara sebelum dimasukkan ke tabel list
    public $selectedJasaId = '';
    public $biayaJasa = '';

    public $selectedSparepartId = '';
    public $jumlahSparepart = '';
    public $hargaSparepart = '';

    // List jasa/sparepart yang sudah ditambahkan (untuk tabel)
    public $jasaList = [];
    public $sparepartList = [];

    public function mount($id)
    {
        $this->service = Service::findOrFail($id);
        $this->jasas = Jasa::all();
        $this->spareparts = Sparepart::all();
    }

    public function addJasa()
    {
        if (!$this->selectedJasaId) return;

        $jasa = Jasa::find($this->selectedJasaId);
        if (!$jasa) return;

        // Cek duplikat agar tidak menambahkan jasa yang sama dua kali
        if (collect($this->jasaList)->contains('jasa_id', $jasa->id)) return;

        $this->jasaList[] = [
            'jasa_id' => $jasa->id,
            'nama_jasa' => $jasa->nama_jasa,
            'harga' => $jasa->harga, // Pastikan kolom ini tersedia di tabel jasa
        ];

        $this->selectedJasaId = null;
    }

    public function removeJasa($index)
    {
        unset($this->jasaList[$index]);
        $this->jasaList = array_values($this->jasaList); // reset index agar tidak ada celah
    }

    public function addSparepart()
    {
        if (!$this->selectedSparepartId || !$this->jumlahSparepart || $this->jumlahSparepart < 1) {
            return; // bisa ditambah validasi lebih lengkap atau pesan error
        }

        $sparepart = $this->spareparts->find($this->selectedSparepartId);
        if (!$sparepart) {
            return;
        }

        $harga = $sparepart->harga;
        $subtotal = $harga * $this->jumlahSparepart;

        $this->sparepartList[] = [
            'sparepart_id' => $sparepart->id,
            'nama' => $sparepart->nama,
            'jumlah' => $this->jumlahSparepart,
            'harga' => $harga,
            'subtotal' => $subtotal,
        ];

        // Reset input jumlah dan selected sparepart
        $this->selectedSparepartId = '';
        $this->jumlahSparepart = '';
    }


    public function removeSparepart($index)
    {
        unset($this->sparepartList[$index]);
        $this->sparepartList = array_values($this->sparepartList);
    }


    public function simpanDetail()
    {
        // Simpan jasa
        foreach ($this->jasaList as $jasa) {
            ServiceJasa::create([
                'service_id' => $this->service->id,
                'jasa_id' => $jasa['jasa_id'],
                'harga' => $jasa['harga'],
            ]);
        }

        // Simpan sparepart
        foreach ($this->sparepartList as $sparepart) {
            ServiceSparepart::create([
                'service_id' => $this->service->id,
                'sparepart_id' => $sparepart['sparepart_id'],
                'harga' => $sparepart['harga'],
                'jumlah' => $sparepart['jumlah'],
                'subtotal' => $sparepart['subtotal'],
            ]);
        }

        session()->flash('success', 'Detail service berhasil disimpan.');
        return redirect()->route('service.view');
    }

    public function render()
    {
        return view('livewire.service.service-detail', [
            'jasas' => $this->jasas,
            'spareparts' => $this->spareparts,
        ]);
    }
}
