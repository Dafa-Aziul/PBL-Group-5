<?php

namespace App\Livewire\Absensi;

use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;


#[Title('Rekap Absensi')]
class Show extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $filterStatus = '';
    public $filterBulan = '';
    public $sortDirection = 'desc';
    public $tanggalAwal;
    public $tanggalAkhir;

    public $start_date;
    public $end_date;
    public $format = 'pdf';
    public $action = '';

    public function mount()
    {
        $this->tanggalAwal = null;
        $this->tanggalAkhir = null;
        // default: tampilkan hari ini saja
    }

    public function updatedTanggalAkhir($value)
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


    public function submitForm()
    {
        $this->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:pdf',
        ]);

        $url = route(
            $this->action === 'preview' ? 'absensi.preview' : 'absensi.export',
            [
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]
        );

        return redirect()->away($url);
    }



    public function updatingSearch()
    {
        $this->emitChartData();
    }

    public function updatedFilterStatus()
    {
        $this->emitChartData();
    }

    public function updatedFilterBulan()
    {
        $this->emitChartData();
    }

    public function emitChartData()
    {
        $this->dispatch('chart-updated', chartData: $this->getAbsensiStatusChartData());
        $this->dispatch('chart-bar-updated', chartStatus: $this->getAllStatusChartData());
    }

    public function getAbsensiStatusChartData()
    {
        $query = Absensi::query()
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterBulan, fn($q) => $q->whereMonth('tanggal', $this->filterBulan))
            ->when($this->search, function ($q) {
                $q->whereHas('karyawan', function ($subQuery) {
                    $subQuery->where('nama', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->tanggalAwal && $this->tanggalAwal !== '', function ($query) {
                $start = Carbon::parse($this->tanggalAwal)->startOfDay();
                $end = $this->tanggalAkhir
                    ? Carbon::parse($this->tanggalAkhir)->endOfDay()
                    : Carbon::parse($this->tanggalAwal)->endOfDay();
                $query->whereBetween('tanggal', [$start, $end]);
            });

        $data = $query->select('status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $allStatuses = ['hadir', 'terlambat', 'izin', 'sakit', 'alpha', 'lembur'];

        return [
            'labels' => array_map('ucfirst', $allStatuses),
            'data' => array_map(fn($status) => $data[$status] ?? 0, $allStatuses),
        ];
    }

    public function getAllStatusChartData()
    {
        $statuses = ['hadir', 'terlambat', 'izin', 'sakit', 'alpha', 'lembur'];

        $karyawans = Karyawan::when($this->search !== '', function ($q) {
            $q->where('nama', 'like', '%' . $this->search . '%');
        })->with(['absensis' => function ($query) {
            if ($this->tanggalAwal && $this->tanggalAwal !== '') {
                $start = Carbon::parse($this->tanggalAwal)->startOfDay();
                $end = $this->tanggalAkhir
                    ? Carbon::parse($this->tanggalAkhir)->endOfDay()
                    : Carbon::parse($this->tanggalAwal)->endOfDay();
                $query->whereBetween('tanggal', [$start, $end]);
            }

            $query->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            });

            $query->when($this->filterBulan, function ($q) {
                $q->whereMonth('tanggal', $this->filterBulan);
            });
        }])->get();


        $labels = $karyawans->pluck('nama')->toArray();

        $datasets = [];

        foreach ($statuses as $status) {
            $datasets[] = [
                'label' => ucfirst($status),
                'data' => $karyawans->map(fn($k) => $k->absensis->where('status', $status)->count())->toArray(),
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }


    public function resetFilters()
    {
        $this->reset(['filterStatus', 'filterBulan', 'search', 'tanggalAwal', 'tanggalAkhir', 'sortDirection']);
        $this->resetPage();
        $this->emitChartData();
    }

    public function render()
    {
        $query = Absensi::with('karyawan')
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('tanggal', 'like', "%{$this->search}%")
                        ->orWhere('jam_masuk', 'like', "%{$this->search}%")
                        ->orWhere('jam_keluar', 'like', "%{$this->search}%")
                        ->orWhere('status', 'like', "%{$this->search}%")
                        ->orWhere('keterangan', 'like', "%{$this->search}%")
                        ->orWhereHas('karyawan', fn($q) => $q->where('nama', 'like', "%{$this->search}%"));
                });
            })->when($this->tanggalAwal && $this->tanggalAwal !== '', function ($query) {
                $start = Carbon::parse($this->tanggalAwal)->startOfDay();
                $end = $this->tanggalAkhir
                    ? Carbon::parse($this->tanggalAkhir)->endOfDay()
                    : Carbon::parse($this->tanggalAwal)->endOfDay();
                $query->whereBetween('tanggal', [$start, $end]);
            })
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterBulan, fn($q) => $q->whereMonth('tanggal', $this->filterBulan))
            ->orderBy('tanggal', $this->sortDirection);

        $absensis = $query->paginate($this->perPage);

        return view('livewire.absensi.show', [
            'absensis' => $absensis,
            'chartData' => $this->getAbsensiStatusChartData(),
            'chartStatus' => $this->getAllStatusChartData()
        ]);
    }
}
