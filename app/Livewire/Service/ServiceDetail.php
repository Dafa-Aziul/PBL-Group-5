<?php

namespace App\Livewire\Service;

use App\Models\Gudang;
use App\Models\Jasa;
use App\Models\Service;
use App\Models\ServiceJasa;
use App\Models\ServiceSparepart;
use App\Models\Sparepart;
use Illuminate\Support\Facades\Log;
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

    public $totalJasa = 0;
    public $totalSparepart = 0;
    public $totalSemua = 0;

    public $editIndex = null;
    public $editJumlah = null;
    // public function mount($id)
    // {
    //     $this->service = Service::findOrFail($id);
    //     $this->jasas = Jasa::all();
    //     $this->spareparts = Sparepart::all();
    // }

    public function hitungTotal()
    {
        Log::info('Hitung Total dipanggil');
        $this->totalJasa = collect($this->jasaList)->sum('harga');
        $this->totalSparepart = collect($this->sparepartList)->sum('sub_total');
        $this->totalSemua = $this->totalJasa + $this->totalSparepart;
        $this->service->update(['estimasi_harga' => $this->totalSemua]);
    }



    public function mount($id)
    {
        $this->service = Service::findOrFail($id);
        $this->jasas = Jasa::all();
        $this->spareparts = Sparepart::all();

        // Ambil jasa yang sudah pernah ditambahkan sebelumnya
        $this->jasaList = $this->service->Jasas()->with('jasa')->get()->map(function ($item) {
            return [
                'jasa_id' => $item->jasa_id,
                'nama_jasa' => $item->jasa->nama_jasa,
                'harga' => $item->harga,
            ];
        })->toArray();

        // Ambil sparepart yang sudah pernah ditambahkan sebelumnya
        $this->sparepartList = $this->service->Spareparts()->with('sparepart')->get()->map(function ($item) {
            return [
                'sparepart_id' => $item->sparepart_id,
                'nama' => $item->sparepart->nama,
                'jumlah' => $item->jumlah,
                'harga' => $item->harga,
                'sub_total' => $item->sub_total,
            ];
        })->toArray();

        $this->hitungTotal(); // hitung ulang grand_total awal
    }

    public function openEditModal($index)
    {
        $this->editIndex = $index;
        $this->editJumlah = $this->sparepartList[$index]['jumlah'];

        // Kirim event ke frontend agar modal dibuka
        $this->dispatch('open-edit-modal');
    }

    public function updateJumlah()
    {
        // Validasi editJumlah
        $this->validate([
            'editJumlah' => 'required|integer|min:1',
        ]);

        // Update jumlah di sparepartList
        $this->sparepartList[$this->editIndex]['jumlah'] = $this->editJumlah;

        // Bisa update sub_total juga, misalnya:
        $this->sparepartList[$this->editIndex]['sub_total'] = $this->editJumlah * $this->sparepartList[$this->editIndex]['harga'];

        // $this->emit('sparepartListUpdated', $this->sparepartList); // Jika perlu

        $this->dispatch('hide-edit-jumlah-modal');
    }


    public function addJasa()
    {
        $this->validate([
            'selectedJasaId' => 'required|exists:jasas,id',
        ], [
            'selectedJasaId.required' => 'Jasa harus dipilih.',
            'selectedJasaId.exists' => 'Jasa yang dipilih tidak valid.',
        ]);

        $jasa = Jasa::find($this->selectedJasaId);

        // Cek duplikat agar tidak menambahkan jasa yang sama dua kali
        if (collect($this->jasaList)->contains('jasa_id', $jasa->id)) {
            $this->addError('selectedJasaId', 'Jasa ini sudah ditambahkan.');
            return;
        }

        $this->jasaList[] = [
            'jasa_id' => $jasa->id,
            'nama_jasa' => $jasa->nama_jasa,
            'harga' => $jasa->harga,
        ];

        $this->selectedJasaId = '';
        $this->hitungTotal();
    }

    public function removeJasa($index)
    {
        unset($this->jasaList[$index]);
        $this->jasaList = array_values($this->jasaList); // reset index agar tidak ada celah
        $this->hitungTotal();
    }

    public function addSparepart()
    {
        $this->validate([
            'selectedSparepartId' => 'required|exists:spareparts,id',
            'jumlahSparepart' => 'required|integer|min:1',
        ], [
            'selectedSparepartId.required' => 'Sparepart harus dipilih.',
            'selectedSparepartId.exists' => 'Sparepart tidak valid.',
            'jumlahSparepart.required' => 'Jumlah tidak boleh kosong.',
            'jumlahSparepart.integer' => 'Jumlah harus berupa angka.',
            'jumlahSparepart.min' => 'Jumlah minimal 1.',
        ]);

        $sparepart = Sparepart::find($this->selectedSparepartId); // aman karena sudah divalidasi exists

        if ($sparepart->stok < 10) {
            $this->addError('selectedSparepartId', 'Stok sparepart ini kurang dari 10 dan tidak dapat digunakan.');
            return;
        }

        // Cek apakah jumlah yang diminta melebihi stok
        if ($this->jumlahSparepart > $sparepart->stok) {
            $this->addError('jumlahSparepart', 'Jumlah yang diminta melebihi stok yang tersedia (' . $sparepart->stok . ').');
            return;
        }

        // Cek jika sparepart sudah ada di daftar (opsional, seperti untuk jasa)
        if (collect($this->sparepartList)->contains('sparepart_id', $sparepart->id)) {
            $this->addError('selectedSparepartId', 'Sparepart ini sudah ditambahkan.');
            return;
        }

        $sub_total = $sparepart->harga * $this->jumlahSparepart;

        $this->sparepartList[] = [
            'sparepart_id' => $sparepart->id,
            'nama' => $sparepart->nama,
            'jumlah' => $this->jumlahSparepart,
            'harga' => $sparepart->harga,
            'sub_total' => $sub_total,
        ];

        $this->selectedSparepartId = '';
        $this->jumlahSparepart = '';
        $this->hitungTotal();
    }



    public function removeSparepart($index)
    {
        unset($this->sparepartList[$index]);
        $this->sparepartList = array_values($this->sparepartList);

        $this->hitungTotal();
    }


    public function simpanDetail()
    {
        $this->validate([
            'jasaList' => 'required|array|min:1',
            // validasi lainnya
        ]);

        ServiceJasa::where('service_id', $this->service->id)->delete();
        ServiceSparepart::where('service_id', $this->service->id)->delete();

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
                'sub_total' => $sparepart['sub_total'],
            ]);

            Gudang::create([
                'sparepart_id' => $sparepart['sparepart_id'],
                'aktivitas' => 'keluar',
                'jumlah' => $sparepart['jumlah'],
                'keterangan' => 'Penggunaan sparepart "'
                    . $sparepart['nama'] . '" sebanyak '
                    . $sparepart['jumlah'] . ' pcs pada service : #'
                    . $this->service->kode_service . ' oleh Pelanggn : '
                    . $this->service->kendaraan->pelanggan->nama . ' (' . $this->service->kendaraan->no_polisi . ')',
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
