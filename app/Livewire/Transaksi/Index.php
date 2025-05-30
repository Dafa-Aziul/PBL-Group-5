<?php

namespace App\Livewire\Transaksi;

use App\Models\Transaksi;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';

    public function mount()
    {
        $this->resetPage(); // reset pagination saat mount
        $this->search = ''; // reset pencarian juga jika diperlukan
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Kembali ke halaman 1 saat pencarian berubah
    }

    public function getChartData()
    {
        $today = Carbon::today();

        $jumlahLunas = Transaksi::whereDate('created_at', $today)
            ->where('status_pembayaran', 'lunas')
            ->count();

        $jumlahPending = Transaksi::whereDate('created_at', $today)
            ->where('status_pembayaran', 'pending')
            ->count();

        return [
            'labels' => ['Lunas', 'Pending'],
            'data' => [$jumlahLunas, $jumlahPending],
        ];
    }
    public function getChartJenis()
    {
        $today = Carbon::today();

        $jumlahService = Transaksi::whereDate('created_at', $today)
            ->where('jenis_transaksi', 'service')
            ->count();

        $jumlahJual = Transaksi::whereDate('created_at', $today)
            ->where('jenis_transaksi', 'penjualan')
            ->count();

        return [
            'labels' => ['Service', 'Penjualan'],
            'data' => [$jumlahService, $jumlahJual],
        ];
    }


    public function render()
    {
        $today = Carbon::today();
        $chartData = $this->getChartData();
        $chartJenis = $this->getChartJenis();

        $totalTransaksiHariIni = Transaksi::whereDate('created_at', $today)->count();
        $totalPendapatanHariIni = Transaksi::whereDate('created_at', $today)->sum('total');
        

        $transaksis = Transaksi::with(['kasir', 'pelanggan'])
            ->where(function ($query) {
                $query->where('kode_transaksi', 'like', '%' . $this->search . '%')
                    ->orWhere('jenis_transaksi', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kasir', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                    ->orWhereHas('pelanggan', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                    ->orWhere('status_pembayaran', 'like', '%' . $this->search . '%')
                    ->orWhere('keterangan', 'like', '%' . $this->search . '%');
            })
            ->paginate($this->perPage);

        return view('livewire.transaksi.index', compact(
            'transaksis',
            'totalTransaksiHariIni',
            'totalPendapatanHariIni',
            'chartData', 'chartJenis'
        ));
    }
}
