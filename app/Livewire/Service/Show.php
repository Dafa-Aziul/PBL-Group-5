<?php

namespace App\Livewire\Service;

use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Detail Data Transaksi')]
class Show extends Component
{
    public $service;
    public $estimasiWaktuReadable = '';

    public function mount($id)
    {
        $this->service = Service::findOrFail($id);
        $this->estimasiWaktuReadable = $this->hitungEstimasiWaktuReadable();
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

    protected function hitungEstimasiWaktuReadable(): string
    {
        $waktu = $this->service->estimasi_waktu ?? '00:00:00';
        [$jam, $menit, $detik] = array_pad(explode(':', $waktu), 3, 0);

        $jam = (int) $jam;
        $menit = (int) $menit;

        $output = [];
        if ($jam > 0) $output[] = "{$jam} jam";
        if ($menit > 0) $output[] = "{$menit} menit";

        return $output ? implode(' ', $output) : '0 menit';
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
