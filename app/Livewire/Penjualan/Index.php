<?php

namespace App\Livewire\Penjualan;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';

    public function render()
    {

        $penjualans = Transaksi::with(['pelanggan'])
            ->where('jenis_transaksi', 'penjualan')
            ->where(function ($query) {
                $query->where('kode_transaksi', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kasir', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                    ->orWhereHas('pelanggan', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                    ->orWhere('status_pembayaran', 'like', '%' . $this->search . '%')
                    ->orWhere('keterangan', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);
        // $penjualans = Transaksi::where('jenis_transaksi', 'penjualan')
        //     ->with(['pelanggan'])
        //     ->latest()
        //     ->paginate(10);
        return view('livewire.penjualan.index', compact('penjualans'));
    }
}
