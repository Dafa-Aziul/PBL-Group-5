<?php

namespace App\Livewire\Absensi;

use App\Models\Absensi;
use App\Models\Karyawan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Carbon\Carbon;

class Show extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $filterStatus = '';
    public $filterBulan = '';
    public $filterMinggu = '';
    public $sortDirection = 'desc'; // 'asc' atau 'desc'

    // Reset pagination saat filter berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterBulan()
    {
        $this->resetPage();
    }
    public function updatingFilterMinggu()
    {
        $this->resetPage();
    }


    public function render()
    {
        $query = Absensi::with('karyawan');
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('tanggal', 'like', '%' . $this->search . '%')
                    ->orWhere('jam_masuk', 'like', '%' . $this->search . '%')
                    ->orWhere('jam_keluar', 'like', '%' . $this->search . '%')
                    ->orWhere('status', 'like', '%' . $this->search . '%')
                    ->orWhere('keterangan', 'like', '%' . $this->search . '%')
                    ->orWhereHas('karyawan', function ($q2) {
                        $q2->where('nama', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        if (!empty($this->filterBulan)) {
            $query->whereMonth('tanggal', $this->filterBulan);
        }

        if (!empty($this->filterMinggu) && !empty($this->filterBulan)) {
            $tahun = Carbon::now()->year;
            $bulan = str_pad($this->filterBulan, 2, '0', STR_PAD_LEFT);

            $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1);
            $startDate = $startOfMonth->copy()->addWeeks($this->filterMinggu - 1)->startOfWeek(Carbon::MONDAY);
            $endDate = $startDate->copy()->endOfWeek(Carbon::SUNDAY);

            if ($startDate->month == $this->filterBulan) {
                $query->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()]);
            }

            // Ganti sortDirection ke ASC
            $this->sortDirection = 'asc';
        }



        $absensis = $query->orderBy('tanggal', $this->sortDirection)->paginate($this->perPage);

        return view('livewire.absensi.show', compact('absensis'));
    }
}
