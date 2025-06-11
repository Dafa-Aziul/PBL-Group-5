<?php

namespace App\Livewire\Service;

use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Detail Data Transaksi')]
class Show extends Component
{
    public $service;

    public function mount($id)
    {
        $this->service = Service::findOrFail($id);
    }

    function getStatusColor(string $status): string
    {
        return match (strtolower($status)) {
            'dalam antrian'    => 'secondary',
            'dianalisis'       => 'warning',
            'analisis selesai' => 'info',
            'dalam proses'     => 'primary',
            'selesai'          => 'success',
            'batal'            => 'danger',
            default            => 'dark',
        };
    }

    public function render()
    {
        $totalJasa = $this->service->jasas->sum('harga');
        $totalSparepart = $this->service->spareparts->sum('sub_total');
        $totalEstimasi = $totalJasa + $totalSparepart;

        return view('livewire.service.show', [
            'totalJasa' => $totalJasa,
            'totalSparepart' => $totalSparepart,
            'totalEstimasi' => $totalEstimasi,
        ]);
    }
}
