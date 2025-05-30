<?php

namespace App\Livewire\Transaksi;

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
    public function updatedTanggalAkhir()
    {
        if ($this->tanggalAwal && $this->tanggalAkhir) {
            if (Carbon::parse($this->tanggalAkhir)->lt(Carbon::parse($this->tanggalAwal))) {
                $this->addError('tanggalAkhir', 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.');
                $this->tanggalAkhir = null; // Reset atau bisa disesuaikan
            } else {
                $this->resetErrorBag('tanggalAkhir');
            }
        }
    }

    public function render()
    {
        $transaksis = Transaksi::with(['kasir', 'pelanggan'])
            ->when(!$this->showAll && !$this->search, function ($query) {
                $start = $this->tanggalAwal ? Carbon::parse($this->tanggalAwal)->startOfDay() : Carbon::today()->startOfDay();
                $end = $this->tanggalAkhir ? Carbon::parse($this->tanggalAkhir)->endOfDay() : Carbon::today()->endOfDay();

                $query->whereBetween('created_at', [$start, $end]);
            })
            ->where(function ($query) {
                $query->where('kode_transaksi', 'like', '%' . $this->search . '%')
                    ->orWhere('jenis_transaksi', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kasir', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                    ->orWhereHas('pelanggan', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                    ->orWhere('status_pembayaran', 'like', '%' . $this->search . '%')
                    ->orWhere('keterangan', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.transaksi.index', compact('transaksis'));
    }
}
