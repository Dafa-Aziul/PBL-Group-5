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

    public $filterBulan = '';

    public $showAll = false;

    protected $listeners = ['chartUpdated' => 'emitChartData'];


    public function mount()
    {
        $this->search = '';
        $this->tanggalAwal = null;
        $this->tanggalAkhir = null;
        $this->filterBulan = '';
        $this->showAll = false;
        $this->emitChartData();
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
        $this->filterBulan = '';
        $this->emitChartData();
    }

    public function updatedFilterBulan()
    {
        $this->emitChartData();
    }

    public function updatedShowAll()
    {
        if ($this->showAll) {
            $this->tanggalAwal = null;
            $this->tanggalAkhir = null;
        }
        $this->emitChartData();
    }

    public function emitChartData()
    {
        $this->dispatch('chart-status-updated', chartData: $this->getStatusPembayaran());
        $this->dispatch('chart-sparepart-updated', chartData: $this->getJumlahSparepartTerjual());
    }

    public function updated()
    {
        $this->emitChartData();
    }

    protected function getFilteredPenjualans()
    {
        // Jika sedang melakukan pencarian, abaikan semua filter tanggal
        if ($this->search) {
            return Transaksi::with(['kasir', 'pelanggan', 'pembayarans'])
                ->where('jenis_transaksi', 'penjualan')
                ->where(function ($query) {
                    $query->where('kode_transaksi', 'like', '%' . $this->search . '%')
                        ->orWhereHas('kasir', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                        ->orWhereHas('pelanggan', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                        ->orWhere('status_pembayaran', 'like', '%' . $this->search . '%')
                        ->orWhere('keterangan', 'like', '%' . $this->search . '%');
                });
        }

        // Jika tidak sedang mencari, baru pakai filter bulan/tanggal
        return Transaksi::with(['kasir', 'pelanggan', 'pembayarans'])
            ->where('jenis_transaksi', 'penjualan')
            ->when(!$this->showAll, function ($query) {
                if ($this->filterBulan) {
                    return $query->whereMonth('created_at', $this->filterBulan);
                }

                if ($this->tanggalAwal && $this->tanggalAkhir) {
                    $start = Carbon::parse($this->tanggalAwal)->startOfDay();
                    $end = Carbon::parse($this->tanggalAkhir)->endOfDay();
                    return $query->whereBetween('created_at', [$start, $end]);
                }

                $todayStart = Carbon::today()->startOfDay();
                $todayEnd = Carbon::today()->endOfDay();
                return $query->whereBetween('created_at', [$todayStart, $todayEnd]);
            });
    }


    protected function getFilteredPenjualansTanpaSearch()
    {
        return Transaksi::with(['kasir', 'pelanggan', 'pembayarans', 'penjualanDetail'])
            ->where('jenis_transaksi', 'penjualan')
            ->when(!$this->showAll, function ($query) {
                // Jika filter bulan diisi, pakai filter bulan
                if ($this->filterBulan) {
                    return $query->whereMonth('created_at', $this->filterBulan);
                }

                // Jika kedua tanggal diisi, pakai rentang tersebut
                if ($this->tanggalAwal && $this->tanggalAkhir) {
                    $start = Carbon::parse($this->tanggalAwal)->startOfDay();
                    $end = Carbon::parse($this->tanggalAkhir)->endOfDay();
                    return $query->whereBetween('created_at', [$start, $end]);
                }

                $todayStart = Carbon::today()->startOfDay();
                $todayEnd = Carbon::today()->endOfDay();
                return $query->whereBetween('created_at', [$todayStart, $todayEnd]);
            });
    }

    public function getStatusPembayaran()
    {
        $query = $this->getFilteredPenjualansTanpaSearch()->get();

        $pending = (clone $query)->where('status_pembayaran', 'pending')->count();
        $lunas = (clone $query)->where('status_pembayaran', 'lunas')->count();

        return [
            'labels' => ['Lunas', 'Pending'],
            'datasets' => [
                'data' => [$lunas, $pending],
                'backgroundColor' => ['rgba(75, 192, 192, 0.6)', 'rgba(255, 205, 86, 0.6)'],
                'borderColor' => ['rgba(75, 192, 192)', 'rgba(255, 205, 86)'],
                'borderWidth' => 1,
            ]
        ];
    }

    public function getJumlahSparepartTerjual()
    {
        $transaksis = $this->getFilteredPenjualansTanpaSearch()->get();

        $details = $transaksis->flatMap(function ($transaksi) {
            return $transaksi->penjualanDetail;
        });

        $spareparts = $details->groupBy(function ($detail) {
            return $detail->sparepart->nama ?? 'Tanpa Nama';
        })->map(function ($group) {
            return $group->sum('jumlah');
        });

        // Ambil label (nama sparepart) dan data (jumlah terjual)
        $labels = $spareparts->keys()->toArray();
        $data = $spareparts->values()->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Terjual',
                    'data' => $data,
                    'backgroundColor' => array_fill(0, count($labels), 'rgba(54, 162, 235, 0.6)'),
                    'borderColor' => array_fill(0, count($labels), 'rgba(54, 162, 235, 1)'),
                    'borderWidth' => 1,
                ]
            ]
        ];
    }


    public function render()
    {
        // $this->emitChartData();
        $penjualans = $this->getFilteredPenjualans()->latest()->paginate($this->perPage);
        return view('livewire.penjualan.index', array_merge(
            compact('penjualans'),
            [
                'chartStatusPembayaran' => $this->getStatusPembayaran(),
                'chartJumlahSparepart' => $this->getJumlahSparepartTerjual(),
            ]
        ));
    }
}
