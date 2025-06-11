<?php

namespace App\Livewire\Transaksi;

use App\Models\Transaksi;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Carbon\Carbon;
use PHPUnit\Event\Emitter;
use Livewire\Attributes\Title;

#[Title('Daftar Transaksi')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';

    public $tanggalAwal;
    public $tanggalAkhir;

    public $filterBulan = '';
    public $jenis_transaksi = '';

    public $showAll = false;

    public function mount()
    {
        $this->search = '';
        $this->tanggalAwal = null;
        $this->tanggalAkhir = null;
        $this->showAll = false;
        $this->filterBulan = '';
        $this->jenis_transaksi = '';
        $this->emitChartData();
        // default: tampilkan hari ini saja
    }

    public function updatedJenisTransaksi()
    {
        $this->emitChartData();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterBulan()
    {
        $this->emitChartData();
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
        $this->jenis_transaksi = '';
        $this->emitChartData();
    }

    public function updatedShowAll()
    {
        if ($this->showAll) {
            $this->tanggalAwal = null;
            $this->tanggalAkhir = null;
            $this->filterBulan = '';
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




    public function emitChartData()
    {
        $this->dispatch('chart-jumlah-transaksi-updated', chartData: $this->getJumlahTransaksiChartData());
        $this->dispatch('chart-pendapatan-updated', chartData: $this->getPendapatanPerMingguChartData());
    }


    protected function getFilteredTransaksis()
    {
        // Jika search aktif, abaikan semua filter lainnya
        if ($this->search) {
            return Transaksi::with(['kasir', 'pelanggan', 'pembayarans'])
                ->where(function ($query) {
                    $query->where('kode_transaksi', 'like', '%' . $this->search . '%')
                        ->orWhere('jenis_transaksi', 'like', '%' . $this->search . '%')
                        ->orWhereHas('kasir', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                        ->orWhereHas('pelanggan', fn($q) => $q->where('nama', 'like', '%' . $this->search . '%'))
                        ->orWhere('status_pembayaran', 'like', '%' . $this->search . '%')
                        ->orWhere('keterangan', 'like', '%' . $this->search . '%');
                });
        }

        // Jika tidak sedang mencari, baru pakai filter bulan/tanggal/jenis
        return Transaksi::with(['kasir', 'pelanggan', 'pembayarans'])
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
            })
            ->when($this->jenis_transaksi, function ($q) {
                $q->where('jenis_transaksi', $this->jenis_transaksi);
            });
    }


    protected function getFilteredTransaksisTanpaSearch()
    {
        return Transaksi::with(['kasir', 'pelanggan', 'pembayarans'])
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
            })->when($this->jenis_transaksi, function ($q) {
                $q->where('jenis_transaksi', $this->jenis_transaksi);
            });
    }


    public function getJumlahTransaksiChartData()
    {
        $query = $this->getFilteredTransaksisTanpaSearch()->get();

        $jumlahService = (clone $query)->where('jenis_transaksi', 'service')->count();
        $jumlahPenjualan = (clone $query)->where('jenis_transaksi', 'penjualan')->count();

        return [
            'labels' => ['Service', 'Penjualan'],
            'datasets' => [
                [
                    'data' => [$jumlahService, $jumlahPenjualan],
                    'backgroundColor' => ['rgba(75, 192, 192, 0.6)', 'rgba(255, 205, 86, 0.6)'],
                    'borderColor' => ['rgba(75, 192, 192)', 'rgba(255, 205, 86)'],
                    'borderWidth' => 1,
                ]
            ],
        ];
    }

    public function getPendapatanPerBulanChartData()
    {
        $query = Transaksi::query();

        $bulanLabels = [];
        $dataService = [];
        $dataPenjualan = [];
        $dataTotal = [];

        if (!empty($this->tanggalAwal) && !empty($this->tanggalAkhir)) {
            $start = Carbon::parse($this->tanggalAwal)->startOfDay();
            $end = Carbon::parse($this->tanggalAkhir)->endOfDay();
        } elseif (!empty($this->filterBulan)) {
            // Jika filterBulan dipilih (1–12), set rentang bulan itu
            $now = now();
            $start = Carbon::create($now->year, $this->filterBulan, 1)->startOfMonth();
            $end = $start->copy()->endOfMonth();
        } else {
            $start = null;
            $end = null;
        }

        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->copy()->subMonths($i);
            $label = $bulan->format('M Y');
            $bulanLabels[] = $label;

            $startOfMonth = $bulan->copy()->startOfMonth();
            $endOfMonth = $bulan->copy()->endOfMonth();

            // Tentukan rentang per bulan sesuai filter aktif
            if ($start && $end) {
                // Jika filter tanggal atau filter bulan aktif, ambil potongan dari masing-masing bulan
                $filterStart = $start->gt($startOfMonth) ? $start : $startOfMonth;
                $filterEnd = $end->lt($endOfMonth) ? $end : $endOfMonth;

                // Lewati bulan yang tidak berada dalam rentang filter
                if ($filterEnd < $startOfMonth || $filterStart > $endOfMonth) {
                    $dataService[] = 0;
                    $dataPenjualan[] = 0;
                    $dataTotal[] = 0;
                    continue;
                }
            } else {
                // Tidak ada filter, tampilkan full bulan
                $filterStart = $startOfMonth;
                $filterEnd = $endOfMonth;
            }

            $service = Transaksi::whereBetween('created_at', [$filterStart, $filterEnd])
                ->where('jenis_transaksi', 'service')->sum('grand_total') ?? 0;
            $penjualan = Transaksi::whereBetween('created_at', [$filterStart, $filterEnd])
                ->where('jenis_transaksi', 'penjualan')->sum('grand_total') ?? 0;

            $dataService[] = $service;
            $dataPenjualan[] = $penjualan;
            $dataTotal[] = $service + $penjualan;
        }

        return [
            'labels' => $bulanLabels,
            'datasets' => [
                [
                    'label' => 'Service',
                    'data' => $dataService,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
                    'stack' => 'pendapatan'
                ],
                [
                    'label' => 'Penjualan',
                    'data' => $dataPenjualan,
                    'backgroundColor' => 'rgba(255, 205, 86, 0.6)',
                    'stack' => 'pendapatan'
                ],
                [
                    'label' => 'Total Pendapatan',
                    'data' => $dataTotal,
                    'type' => 'line',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderWidth' => 2,
                    'tension' => 0.3,
                    'fill' => false,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6
                ]
            ],
        ];
    }

    public function getPendapatanPerMingguChartData()
{
    $mingguLabels = [];
    $dataService = [];
    $dataPenjualan = [];
    $dataTotal = [];

    // Tentukan bulan yang akan ditampilkan
    if (!empty($this->filterBulan)) {
        $tahun = now()->year;
        $startOfMonth = Carbon::create($tahun, $this->filterBulan, 1)->startOfMonth();
    } else {
        $startOfMonth = now()->startOfMonth();
    }
    $endOfMonth = $startOfMonth->copy()->endOfMonth();

    // Atur minggu pertama agar selalu dimulai dari Senin
    $currentWeekStart = $startOfMonth->copy();
    if ($currentWeekStart->dayOfWeek != Carbon::MONDAY) {
        $currentWeekStart->previous(Carbon::MONDAY); // Kembali ke Senin sebelumnya
    }

    $weekNumber = 1;

    while ($currentWeekStart <= $endOfMonth) {
        $currentWeekEnd = $currentWeekStart->copy()->addDays(6); // Minggu = Senin-Minggu

        // Buat label
        $label = 'Minggu ' . $weekNumber . ' (' . $currentWeekStart->format('d M') . ' - ' .
                $currentWeekEnd->format('d M') . ')';

        // Hanya tambahkan ke data jika minggu ini beririsan dengan bulan yang dipilih
        if ($currentWeekEnd >= $startOfMonth && $currentWeekStart <= $endOfMonth) {
            $mingguLabels[] = $label;

            // Tentukan rentang waktu yang valid dalam bulan
            $effectiveStart = $currentWeekStart->lt($startOfMonth) ? $startOfMonth : $currentWeekStart;
            $effectiveEnd = $currentWeekEnd->gt($endOfMonth) ? $endOfMonth : $currentWeekEnd;

            // Query data
            $service = Transaksi::whereBetween('created_at', [$effectiveStart, $effectiveEnd])
                      ->where('jenis_transaksi', 'service')->sum('grand_total') ?? 0;
            $penjualan = Transaksi::whereBetween('created_at', [$effectiveStart, $effectiveEnd])
                        ->where('jenis_transaksi', 'penjualan')->sum('grand_total') ?? 0;

            $dataService[] = $service;
            $dataPenjualan[] = $penjualan;
            $dataTotal[] = $service + $penjualan;
        }

        // Pindah ke minggu berikutnya (Senin depan)
        $currentWeekStart = $currentWeekEnd->copy()->addDay();
        $weekNumber++;
    }

    return [
        'labels' => $mingguLabels,
        'datasets' => [
            [
                'label' => 'Service',
                'data' => $dataService,
                'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
                'stack' => 'pendapatan'
            ],
            [
                'label' => 'Penjualan',
                'data' => $dataPenjualan,
                'backgroundColor' => 'rgba(255, 205, 86, 0.6)',
                'stack' => 'pendapatan'
            ],
            [
                'label' => 'Total Pendapatan',
                'data' => $dataTotal,
                'type' => 'line',
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderWidth' => 2,
                'tension' => 0.3,
                'fill' => false,
                'pointRadius' => 4,
                'pointHoverRadius' => 6
            ]
        ],
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

            'penjualan' => $this->getFilteredTransaksisTanpaSearch()
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
        $statPembayaran = $this->hitungPembayaranStatus();

        return view('livewire.transaksi.index', array_merge(
            compact(
                'transaksis',
                'totalPendapatan',
                'pendapatanPerJenis',
                'statPembayaran',
            ),
            [
                'chartPendapatan' => $this->getPendapatanPerMingguChartData(),
                'chartJumlahTransaksi' => $this->getJumlahTransaksiChartData(),
            ]
        ));
    }
}
