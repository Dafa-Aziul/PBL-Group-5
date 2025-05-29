<?php

namespace App\Livewire\Absensi;

use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

class Read extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 15;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $today = Carbon::today()->toDateString();

        $karyawans = Karyawan::with(['absensis' => function ($query) use ($today) {
            $query->where('tanggal', $today);
        }])
            ->where('nama', 'like', '%' . $this->search . '%') // filter pencarian jika ada
            ->paginate($this->perPage);


        return view('livewire.absensi.read', compact('karyawans'));
    }
}
