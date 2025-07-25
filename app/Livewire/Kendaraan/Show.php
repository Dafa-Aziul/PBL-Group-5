<?php

namespace App\Livewire\Kendaraan;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Detail Kendaraan')]
class Show extends Component
{
    public Pelanggan $pelanggan;
    public Kendaraan $kendaraan;

    public function mount(Pelanggan $pelanggan, Kendaraan $kendaraan)
    {
        // Validasi kendaraan milik pelanggan
        abort_if($kendaraan->pelanggan_id !== $pelanggan->id, 403);

        $this->pelanggan = $pelanggan;
        $this->kendaraan = $kendaraan->load(['services' => function ($query) {
            $query->whereIn('status', ['selesai', 'batal'])
                ->orderBy('tanggal_selesai_service', 'desc'); // atau 'created_at', tergantung kebutuhan
        }]);
    }

    public function render()
    {
        return view('livewire.kendaraan.show');
    }
}
