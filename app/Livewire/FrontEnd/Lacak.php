<?php

namespace App\Livewire\FrontEnd;

use App\Models\Service;
use App\Models\StatusService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Carbon;

#[Layout('layouts.guest')]
class Lacak extends Component
{
    public $input;
    public $status;
    public $currentStatus;
    public $allStatus = [
        'dalam antrian',
        'dianalisis',
        'analisis selesai',
        'dalam proses',
        'selesai',
        'batal'
    ];
    public $statusHistory = [];
    public $service;

    public function getStatusColor($statusName)
    {
        $currentIndex = array_search(strtolower($this->currentStatus), $this->allStatus);
        $statusIndex = array_search(strtolower($statusName), $this->allStatus);

        if ($statusIndex === false) return 'secondary'; // fallback warna abu

        return $statusIndex <= $currentIndex ? 'primary' : 'secondary';
    }

    public function checkStatus()
    {
        $search = strtoupper(trim($this->input));

        $this->service = Service::with('montir')
            ->where(function ($q) use ($search) {
                $q->where('kode_service', $search);
            })
            ->first();

        if ($this->service) {
            $allHistory = StatusService::where('service_id', $this->service->id)
                ->orderBy('changed_at')
                ->get();

            $this->statusHistory = $allHistory;

            // Ambil currentStatus dari data TERAKHIR
            $this->currentStatus = $allHistory->last()?->status;

            $this->status = null;
        } else {
            $this->status = "Nomor tidak ditemukan. Silakan hubungi admin.";
            $this->currentStatus = null;
            $this->statusHistory = [];
            $this->service = null;
        }
    }

    public function render()
    {
        return view('livewire.front-end.lacak');
    }
}
