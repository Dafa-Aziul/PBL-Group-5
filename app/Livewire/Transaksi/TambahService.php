<?php

namespace App\Livewire\Transaksi;

use App\Livewire\Forms\TransaksiServiceForm;
use App\Models\Pembayaran;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\Transaksi;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TambahService extends Component
{
    public $service;
    public TransaksiServiceForm $form;
    public float $total_diskon = 0;

    #[Validate('required|integer|unique:transaksis')]
    public $service_id;

    public function mount($id)
    {
        $this->service = Service::findOrFail($id);
        $this->service_id = $this->service->id;
        $this->form->fillFormModel($this->service);

        // Hitung sub grand_total
        // Hitung pajak dan grand_total
        $this->form->pajak = round(0.11 * $this->form->sub_total, 2);
        $this->form->grand_total = $this->form->sub_total + $this->form->pajak;
    }

    public function updatedFormDiskon($value)
    {
        // Jika kosong, kembalikan ke 0
        if ($value === null || $value === '') {
            $this->form->diskon = 0;
        } else {
            // Buang angka nol di depan, tapi biarkan jika hanya 0
            $cleaned = ltrim($value, '0');
            $this->form->diskon = $cleaned === '' ? 0 : intval($cleaned);
        }

        // Hitung grand_total diskon dan grand_total keseluruhan
        $diskonPersen = floatval($this->form->diskon);
        $this->total_diskon = $this->form->sub_total * ($diskonPersen / 100);
        $this->form->grand_total = $this->form->sub_total + $this->form->pajak - $this->total_diskon;
    }

    public function store()
    {
        $validated = $this->form->validate();

        if (ServiceDetail::where('service_id', $this->service->id)->exists()) {
            $this->addError('service_id', 'Service ini sudah memiliki transaksi.');
            return;
        }
        $transaksi = Transaksi::create($validated);

        $serviceDetail = ServiceDetail::create([
            'transaksi_id' => $transaksi->id,
            'service_id' => $this->service_id,
            'sub_total' => $this->form->grand_total,

        ]);
        // Jika status pembayaran lunas, otomatis catat pembayaran penuh
        if ($validated['status_pembayaran'] === 'lunas') {
            Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'tanggal_bayar' => now(),
                'jumlah_bayar' => $transaksi->grand_total,
                'status_pembayaran' => 'lunas',
                'ket' => 'Pembayaran otomatis saat transaksi dibuat',
            ]);
        }
        session()->flash('success', 'Transaksi berhasil disimpan!');
        return redirect()->route('transaksi.view'); // contoh redirect
    }

    public function render()
    {
        $totalJasa = $this->service->jasas->sum('harga');
        $totalSparepart = $this->service->spareparts->sum('sub_total');
        $totalEstimasi = $totalJasa + $totalSparepart;
        return view('livewire.transaksi.tambah-service', [
            'totalJasa' => $totalJasa,
            'totalSparepart' => $totalSparepart,
            'totalEstimasi' => $totalEstimasi,
        ]);
    }
}
