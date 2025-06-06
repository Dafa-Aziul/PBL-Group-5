<?php

namespace App\Livewire\Transaksi;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Carbon\Carbon;
use PHPUnit\Event\Emitter;

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
        $this->emitChartData();
    }

    public function updatedShowAll()
    {
        if ($this->showAll) {
            $this->tanggalAwal = null;
            $this->tanggalAkhir = null;
        }
        $this->resetPage();
        $this->emitChartData();
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
        $this->emitChartData();
    }

    public function getDataChartData() {}

    public function getPendapatanPerBulanChartData()
    {
        $query = Transaksi::query();

        // Filter tanggal (opsional)
        if ($this->tanggalAwal && $this->tanggalAwal !== '') {
            $start = Carbon::parse($this->tanggalAwal)->startOfDay();
            $end = $this->tanggalAkhir
                ? Carbon::parse($this->tanggalAkhir)->endOfDay()
                : Carbon::parse($this->tanggalAwal)->endOfDay();

            $query->whereBetween('created_at', [$start, $end]);
        }

        $bulanLabels = [];
        $data = [];

        // Karena $query sudah ada filter tanggal, kita harus override filter bulan
        // Supaya tidak tumpang tindih, kita lakukan query baru per bulan dengan filter tanggal sesuai bulan

        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->copy()->subMonths($i);
            $label = $bulan->format('M Y');
            $bulanLabels[] = $label;

            $startOfMonth = $bulan->copy()->startOfMonth();
            $endOfMonth = $bulan->copy()->endOfMonth();

            // Supaya filter tanggal tetap dipakai, kita ambil intersection dengan filter tanggal awal dan akhir
            if ($this->tanggalAwal && $this->tanggalAwal !== '') {
                $filterStart = $start->gt($startOfMonth) ? $start : $startOfMonth;
                $filterEnd = $end->lt($endOfMonth) ? $end : $endOfMonth;
            } else {
                $filterStart = $startOfMonth;
                $filterEnd = $endOfMonth;
            }

            // Hitung total untuk bulan ini
            $total = Transaksi::whereBetween('created_at', [$filterStart, $filterEnd])
                ->sum('grand_total');

            $data[] = $total;
        }

        return [
            'labels' => $bulanLabels,
            'datasets' => [
                [
                    'label' => 'Pendapatan Bulanan',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                    'fill' => false,
                ]
            ],
        ];
    }


    public function emitChartData()
    {
        $this->dispatch('chart-pendapatan-updated', chartPendapatanBulanan: $this->getPendapatanPerBulanChartData());
    }

    protected function getFilteredTransaksis()
    {
        return Transaksi::with(['kasir', 'pelanggan', 'pembayarans'])
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
            });
    }

    protected function getFilteredTransaksisTanpaSearch()
    {
        return Transaksi::with(['kasir', 'pelanggan', 'pembayarans'])
            ->when(!$this->showAll, function ($query) {
                $start = $this->tanggalAwal ? Carbon::parse($this->tanggalAwal)->startOfDay() : Carbon::today()->startOfDay();
                $end = $this->tanggalAkhir ? Carbon::parse($this->tanggalAkhir)->endOfDay() : Carbon::today()->endOfDay();
                $query->whereBetween('created_at', [$start, $end]);
            });
    }


    protected function hitungJumlahTransaksi()
    {
        $query = $this->getFilteredTransaksisTanpaSearch();

        return [
            'total' => $query->count(),
            'service' => (clone $query)->where('jenis_transaksi', 'service')->count(),
            'penjualan' => (clone $query)->where('jenis_transaksi', 'penjualan')->count(),
        ];
    }

    protected function hitungTotalPendapatan()
    {
        return $this->getFilteredTransaksisTanpaSearch()
            ->sum('grand_total');
    }

    protected function hitungPendapatanPerJenis()
    {
        return [
            'service' => $this->getFilteredTransaksisTanpaSearch()
                ->where('jenis_transaksi', 'service')
                ->sum('grand_total'),

            'penjualan' => $this->getFilteredTransaksis()
                ->where('jenis_transaksi', 'penjualan')
                ->sum('grand_total'),
        ];
    }

    protected function hitungPembayaranStatus()
    {
        $transaksis = $this->getFilteredTransaksisTanpaSearch()->with('pembayarans')->get();

        $totalBayar = 0;    // total pembayaran (status lunas + pending)
        $totalPending = 0;  // total pending (selisih grand_total - total bayar per transaksi)

        foreach ($transaksis as $transaksi) {
            // Total bayar di transaksi ini (baik lunas maupun pending)
            $totalBayar += $transaksi->pembayarans->sum('jumlah_bayar');

            // Total bayar (semua status) di transaksi ini
            $totalBayarTransaksi = $transaksi->pembayarans->sum('jumlah_bayar');

            if ($totalBayarTransaksi == 0) {
                // Belum ada pembayaran sama sekali -> pending = grand_total
                $totalPending += $transaksi->grand_total;
            } else {
                // Pending = grand_total - total bayar (lunas+pending)
                $pendingTransaksi = $transaksi->grand_total - $totalBayarTransaksi;

                $totalPending += max($pendingTransaksi, 0);
            }
        }

        return [
            'total_bayar' => $totalBayar,
            'pending' => $totalPending,
        ];
    }


    public function render()
    {
        $transaksis = $this->getFilteredTransaksis()->orderByDesc('created_at')->paginate($this->perPage);

        $totalPendapatan = $this->hitungTotalPendapatan();
        $pendapatanPerJenis = $this->hitungPendapatanPerJenis();
        $jumlahTransaksi = $this->hitungJumlahTransaksi();
        $statPembayaran = $this->hitungPembayaranStatus();


        return view('livewire.transaksi.index', array_merge(
            compact(
                'transaksis',
                'totalPendapatan',
                'pendapatanPerJenis',
                'jumlahTransaksi',
                'statPembayaran',
            ),
            ['chartPendapatanBulanan' => $this->getPendapatanPerBulanChartData()]
        ));
    }
}
