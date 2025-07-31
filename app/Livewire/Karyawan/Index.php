<?php

namespace App\Livewire\Karyawan;

use App\Models\Karyawan;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('Daftar Data Karyawan')]
class Index extends Component
{
    use WithPagination;
    public $perPage = 5;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $filterRole = '';
    public $filterBulan = '';
    public $tanggalAwal;
    public $tanggalAkhir;

    public function mount()
    {
        $this->search = '';
        $this->tanggalAwal = null;
        $this->tanggalAkhir = null;
        $this->filterBulan = '';
        $this->filterRole = '';
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->emitChartData();
    }

    public function updatedFilterRole()
    {
        $this->emitChartData();
    }



    public function updatedFilterBulan()
    {
        $this->emitChartData();
    }

    public function updatedTanggalAwal()
    {
        $this->emitChartData();
    }

    public function updatedTanggalAkhir()
    {
        $this->emitChartData();
    }

    public function emitChartData()
    {
        $this->dispatch('chart-updated', chartPerformance: $this->getAllPerformanceChartData());
    }

    public function resetFilters()
    {
        $this->reset(['filterRole', 'filterBulan', 'search', 'tanggalAwal', 'tanggalAkhir']);
        $this->resetPage();
        $this->emitChartData();
    }

    public function getAllPerformanceChartData()
    {
        // Ambil filter bulan jika valid
        $bulan = is_numeric($this->filterBulan) && $this->filterBulan >= 1 && $this->filterBulan <= 12
            ? (int) $this->filterBulan
            : null;

        // Tentukan range tanggal awal dan akhir
        $tanggalAwal = $this->tanggalAwal
            ? Carbon::parse($this->tanggalAwal)->startOfDay()
            : ($bulan
                ? Carbon::createFromDate(now()->year, $bulan, 1)->startOfMonth()
                : Carbon::now()->subMonth()->startOfDay());

        $tanggalAkhir = $this->tanggalAkhir
            ? Carbon::parse($this->tanggalAkhir)->endOfDay()
            : ($bulan
                ? Carbon::createFromDate(now()->year, $bulan, 1)->endOfMonth()
                : Carbon::now()->endOfDay());

        // Validasi jika tanggal awal lebih besar dari tanggal akhir
        if ($tanggalAwal->gt($tanggalAkhir)) {
            $tanggalAwal = $tanggalAkhir->copy()->subMonth();
        }

        // Ambil data karyawan dan relasi
        $kinerja = Karyawan::query()
            ->whereHas('user', function ($query) {
                $query->whereIn('role', ['admin', 'mekanik']);
            })
            ->when($this->filterRole, function ($q) {
                $q->whereHas('user', function ($userQuery) {
                    $userQuery->where('role', $this->filterRole);
                });
            })
            ->with([
                'user',
                'services' => function ($q) use ($tanggalAwal, $tanggalAkhir) {
                    $q->whereBetween('tanggal_mulai_service', [$tanggalAwal, $tanggalAkhir]);
                },
                'transaksis' => function ($q) use ($tanggalAwal, $tanggalAkhir) {
                    $q->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
                }
            ])
            ->get();


        // Generate label tanggal
        $tanggalLabel = collect();
        $date = $tanggalAwal->copy();
        while ($date <= $tanggalAkhir) {
            $tanggalLabel->push($date->format('Y-m-d')); // Gunakan format Y-m-d agar mudah dibanding
            $date->addDay();
        }

        $datasets = [];

        foreach ($kinerja as $karyawan) {
            // Lewati jika user role tidak sesuai filter
            if (
                in_array($this->filterRole, ['admin', 'mekanik']) &&
                optional($karyawan->user)->role !== $this->filterRole
            ) {
                continue;
            }

            $data = [];

            foreach ($tanggalLabel as $tanggalStr) {
                $tanggalCarbon = Carbon::parse($tanggalStr);

                $jumlah = 0;

                if ($this->filterRole === 'admin') {
                    $jumlah = $karyawan->transaksis
                        ->filter(fn($t) => Carbon::parse($t->created_at)->isSameDay($tanggalCarbon))
                        ->count();
                } elseif ($this->filterRole === 'mekanik') {
                    $jumlah = $karyawan->services
                        ->filter(fn($s) => Carbon::parse($s->tanggal_mulai_service)->isSameDay($tanggalCarbon))
                        ->count();
                } else {
                    $jumlahTransaksi = $karyawan->transaksis
                        ->filter(fn($t) => Carbon::parse($t->created_at)->isSameDay($tanggalCarbon))
                        ->count();
                    $jumlahService = $karyawan->services
                        ->filter(fn($s) => Carbon::parse($s->tanggal_mulai_service)->isSameDay($tanggalCarbon))
                        ->count();

                    $jumlah = $jumlahTransaksi + $jumlahService;
                }

                $data[] = $jumlah;
            }

            $datasets[] = [
                'label' => $karyawan->nama,
                'data' => $data,
            ];
        }

        return [
            'labels' => $tanggalLabel->map(fn($t) => Carbon::parse($t)->format('d M'))->toArray(),
            'datasets' => $datasets,
        ];
    }


    public function delete($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();
        session()->flash('success', 'Data Karyawan Berhasil Dihapus');
        $this->emitChartData(); // Refresh chart setelah menghapus
    }

    public function render()
    {
        $karyawans = Karyawan::query()
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('jabatan', 'like', '%' . $this->search . '%')
                        ->orWhere('alamat', 'like', '%' . $this->search . '%')
                        ->orWhere('no_hp', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filterRole, function ($q) {
                $q->whereHas('user', function ($userQuery) {
                    $userQuery->where('role', $this->filterRole);
                });
            })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.karyawan.index', [
            'karyawans' => $karyawans,
            'chartPeformance' => $this->getAllPerformanceChartData(),
        ]);
    }
}
