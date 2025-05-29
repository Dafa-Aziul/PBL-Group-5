<?php

namespace App\Livewire\Penjualan;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Carbon\Carbon;

class Index extends Component
{

    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';

    public $tanggalAwal;
    public $tanggalAkhir;
    public $showAll = false;

    public function mount()
    {
        $this->search = '';
        $this->tanggalAwal = null;
        $this->tanggalAkhir = null;
        $this->showAll = false;
        // default: tampilkan hari ini saja
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->tanggalAwal = null;
        $this->tanggalAkhir = null;
        $this->search = '';
        $this->showAll = false;
        $this->resetPage();
        $this->perPage = 5;
    }

    public function updatedShowAll()
    {
        if ($this->showAll) {
            $this->tanggalAwal = null;
            $this->tanggalAkhir = null;
        }
        $this->resetPage();
    }

    public function render()
    {

        $penjualans = Transaksi::with(['pelanggan'])
            ->where('jenis_transaksi', 'penjualan')
            ->when(!$this->showAll, function ($query) {
                $start = $this->tanggalAwal ? Carbon::parse($this->tanggalAwal)->startOfDay() : Carbon::today()->startOfDay();
                $end = $this->tanggalAkhir ? Carbon::parse($this->tanggalAkhir)->endOfDay() : Carbon::today()->endOfDay();

                $query->whereBetween('created_at', [$start, $end]);
            })
            ->where(function ($query) {
                $query->where('kode_transaksi', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kasir', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                    ->orWhereHas('pelanggan', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                    ->orWhere('status_pembayaran', 'like', '%' . $this->search . '%')
                    ->orWhere('keterangan', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);
        return view('livewire.penjualan.index', compact('penjualans'));
    }
}
