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

    public $chartData = [];
    public $chartJenis = [];

    public function mount()
    {
        $this->search = '';
        $this->tanggalAwal = null;
        $this->tanggalAkhir = null;
        $this->showAll = false;
        // default: tampilkan hari ini saja
        $this->updateChartData(); // <--- ini tambahan
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
        $this->updateChartData();
        $this->dispatch('chartUpdated', [
            'chartData' => $this->chartData,
            'chartJenis' => $this->chartJenis,
        ]);
    }

    public function updatedTanggalAwal()
    {
        $this->updateChartData();
        $this->dispatch('chartUpdated', [
            'chartData' => $this->chartData,
            'chartJenis' => $this->chartJenis,
        ]);
    }

    public function updatedTanggalAkhir()
    {
        if ($this->tanggalAwal && $this->tanggalAkhir) {
            if (Carbon::parse($this->tanggalAkhir)->lt(Carbon::parse($this->tanggalAwal))) {
                $this->addError('tanggalAkhir', 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.');
                $this->tanggalAkhir = null;
                return;
            } else {
                $this->resetErrorBag('tanggalAkhir');
            }
        }
        $this->updateChartData();
        $this->dispatch('chartUpdated', [
            'chartData' => $this->chartData,
            'chartJenis' => $this->chartJenis,
        ]);
    }


    // public function updatedShowAll()
    // {
    //     if ($this->showAll) {
    //         $this->tanggalAwal = null;
    //         $this->tanggalAkhir = null;
    //     }
    //     $this->resetPage();
    // }
    // public function updatedTanggalAkhir()
    // {
    //     if ($this->tanggalAwal && $this->tanggalAkhir) {
    //         if (Carbon::parse($this->tanggalAkhir)->lt(Carbon::parse($this->tanggalAwal))) {
    //             $this->addError('tanggalAkhir', 'Tanggal akhir tidak boleh lebih awal dari tanggal awal.');
    //             $this->tanggalAkhir = null; // Reset atau bisa disesuaikan
    //         } else {
    //             $this->resetErrorBag('tanggalAkhir');
    //         }
    //     }
    // }

    // public function getChartData()
    // {
    //     $today = Carbon::today();

    //     $jumlahLunas = Transaksi::whereDate('created_at', $today)
    //         ->where('status_pembayaran', 'lunas')
    //         ->count();

    //     $jumlahPending = Transaksi::whereDate('created_at', $today)
    //         ->where('status_pembayaran', 'pending')
    //         ->count();

    //     return [
    //         'labels' => ['Lunas', 'Pending'],
    //         'data' => [$jumlahLunas, $jumlahPending],
    //     ];
    // }
    // public function getChartJenis()
    // {
    //     $today = Carbon::today();

    //     $jumlahService = Transaksi::whereDate('created_at', $today)
    //         ->where('jenis_transaksi', 'service')
    //         ->count();

    //     $jumlahJual = Transaksi::whereDate('created_at', $today)
    //         ->where('jenis_transaksi', 'penjualan')
    //         ->count();

    //     return [
    //         'labels' => ['Service', 'Penjualan'],
    //         'data' => [$jumlahService, $jumlahJual],
    //     ];
    // }

    public function updateChartData()
    {
        if ($this->showAll) {
            $start = Transaksi::min('created_at') ?? Carbon::today()->startOfDay();
            $end = Transaksi::max('created_at') ?? Carbon::today()->endOfDay();
        } else {
            $start = $this->tanggalAwal ? Carbon::parse($this->tanggalAwal)->startOfDay() : Carbon::today()->startOfDay();
            $end = $this->tanggalAkhir ? Carbon::parse($this->tanggalAkhir)->endOfDay() : Carbon::today()->endOfDay();
        }

        $this->chartData = [
            'labels' => ['Lunas', 'Pending'],
            'data' => [
                Transaksi::whereBetween('created_at', [$start, $end])->where('status_pembayaran', 'lunas')->count(),
                Transaksi::whereBetween('created_at', [$start, $end])->where('status_pembayaran', 'pending')->count()
            ]
        ];

        $this->chartJenis = [
            'labels' => ['Service', 'Penjualan'],
            'data' => [
                Transaksi::whereBetween('created_at', [$start, $end])->where('jenis_transaksi', 'service')->count(),
                Transaksi::whereBetween('created_at', [$start, $end])->where('jenis_transaksi', 'penjualan')->count()
            ]
        ];

        // Debugging
        logger()->info('Chart updated', [
            'showAll' => $this->showAll,
            'start' => $start,
            'end' => $end,
            'chartData' => $this->chartData,
            'chartJenis' => $this->chartJenis,
        ]);
    }





    public function render()
    {
        $today = Carbon::today();
        // $chartData = $this->getChartData();
        // $chartJenis = $this->getChartJenis();

        $totalTransaksiHariIni = Transaksi::whereDate('created_at', $today)->count();
        $totalPendapatanHariIni = Transaksi::whereDate('created_at', $today)->sum('grand_total');

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

        // return view('livewire.transaksi.index', compact(
        //     'transaksis',
        //     'totalTransaksiHariIni',
        //     'totalPendapatanHariIni',
        //     'chartData', 'chartJenis'
        // ));

        return view('livewire.transaksi.index', [
            'transaksis' => $transaksis,
            'totalTransaksiHariIni' => $totalTransaksiHariIni,
            'totalPendapatanHariIni' => $totalPendapatanHariIni,
            'chartData' => $this->chartData,
            'chartJenis' => $this->chartJenis,
        ]);
    }
}
