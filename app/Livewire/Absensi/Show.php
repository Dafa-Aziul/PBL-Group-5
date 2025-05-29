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
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $sortDirection = 'desc'; // 'asc' atau 'desc'

    // Reset pagination saat filter berubah
    public function updatingSearch()
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

        $absensis = $query->orderBy('tanggal', $this->sortDirection)
            ->paginate($this->perPage);


        return view('livewire.absensi.show', compact('absensis'));
    }
}
