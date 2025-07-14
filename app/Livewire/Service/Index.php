<?php

namespace App\Livewire\Service;

use App\Livewire\Kendaraan\RiwayatService;
use App\Models\Service;
use App\Models\StatusService;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;

#[Title('Daftar Services')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';

    public $tanggalAwal;
    public $tanggalAkhir;
    public $filterBulan;
    public $showAll = false;

    // Array untuk menyimpan status masing-masing service by id
    public $statuses = [];

    public function updateStatus($id)
    {
        $validStatuses = [
            'dalam antrian' => 1,
            'dianalisis' => 2,
            'analisis selesai' => 3,
            'dalam proses' => 4,
            'selesai' => 5,
            'batal' => 6,
        ];

        // Cek status baru dari input user
        if (!isset($this->statuses[$id]) || !isset($validStatuses[$this->statuses[$id]])) {
            session()->flash('error', 'Status tidak valid.');
            return;
        }

        $newStatus = strtolower($this->statuses[$id]);

        // Ambil data service dengan relasi yang dibutuhkan
        $service = Service::with(['montir', 'jasas'])->find($id);
        if (!$service) {
            session()->flash('error', 'Data service tidak ditemukan.');
            return;
        }

        $oldStatus = strtolower($service->status);

        // Cek validitas status lama
        if (!isset($validStatuses[$oldStatus])) {
            $this->addError('statuses.' . $service->id, 'Status lama tidak dikenali.');
            return;
        }

        // Cek apakah status baru adalah mundur dari status lama
        if ($validStatuses[$newStatus] < $validStatuses[$oldStatus]) {
            $this->addError('statuses.' . $service->id, 'Tidak bisa mengubah status ke tahap sebelumnya.');
            return;
        }

        // Cek jasa detail sebelum pindah ke "dalam proses"
        if (
            in_array($newStatus, ['dalam proses', 'selesai']) &&
            $service->jasas->isEmpty()
        ) {
            $this->addError('statuses.' . $service->id, 'Tidak dapat mengubah status ke "' . $newStatus . '" karena detail jasa belum ditambahkan.');
            return;
        }

        // Siapkan data update
        $dataUpdate = ['status' => $newStatus];

        if ($newStatus === 'selesai') {
            $dataUpdate['tanggal_selesai_service'] = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        } else {
            $dataUpdate['tanggal_selesai_service'] = null;
        }

        $updated = Service::where('id', $id)->update($dataUpdate);

        if ($updated) {
            $statusSudahAda = StatusService::where('service_id', $service->id)
                ->where('status', $newStatus)
                ->exists();

            if ($statusSudahAda) {
                $this->addError('statuses.' . $service->id, 'Status "' . $newStatus . '" sudah pernah dicatat sebelumnya.');
                return;
            }

            $namaMontir = $service->montir->nama ?? 'montir';
            $estimasiWaktu = $this->formatEstimasiWaktu($service->estimasi_waktu);

            $keterangan = match ($newStatus) {
                'dalam antrian'     => 'Service telah masuk ke dalam antrian.',
                'dianalisis'        => 'Service sedang dalam proses analisis oleh ' . $namaMontir . '.',
                'analisis selesai'  => 'Analisis telah selesai dilakukan oleh ' . $namaMontir . '.',
                'dalam proses'      => 'Service sedang dikerjakan oleh ' . $namaMontir . ', estimasi pengerjaan selesai dalam ' . $estimasiWaktu,
                'selesai'           => 'Service telah selesai dan siap diambil.',
                'batal'             => 'Service dibatalkan oleh pelanggan atau admin.',
                default             => null,
            };

            StatusService::create([
                'service_id' => $service->id,
                'kode_service' => $service->kode_service,
                'status' => $newStatus,
                'keterangan' => $keterangan,
                'changed_at' => Carbon::now('Asia/Jakarta'),
            ]);

            if ($newStatus === 'selesai') {
                $this->dispatch('tampilkanModalTransaksi', $service->id);
            }
            $this->emitChartData();
            session()->flash('success', 'Status berhasil diperbarui.');
        } else {
            session()->flash('error', 'Gagal memperbarui status service.');
        }
    }

    public function updatedFilterBulan()
    {
        $this->emitChartData();
    }

    public function mount()
    {
        $this->search = '';
        $this->tanggalAwal = null;
        $this->tanggalAkhir = null;
        $this->filterBulan = "";
        $this->showAll = false;
        $this->emitChartData();
    }

    public function updatingSearch()
    {
        $this->emitChartData();
    }

    public function resetFilter()
    {
        $this->tanggalAwal = null;
        $this->tanggalAkhir = null;
        $this->search = '';
        $this->showAll = false;
        $this->filterBulan = "";
        $this->perPage = 5;
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
        $this->dispatch('chart-status-updated', chartData: $this->getStatusChart());
        $this->dispatch('chart-jumlah-service-updated', chartData: $this->getJumlahServicePerHariLineChart());
    }

    protected function getFilteredServices()
    {
        return  Service::with(['kendaraan.pelanggan'])
            ->where(function ($query) {
                $query->where('kode_service', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kendaraan', function ($q) {
                        $q->where('no_polisi', 'like', '%' . $this->search . '%')
                            ->orWhere('tipe_kendaraan', 'like', '%' . $this->search . '%')
                            ->orWhereHas('pelanggan', function ($sub) {
                                $sub->where('nama', 'like', '%' . $this->search . '%');
                            });
                    })
                    ->orWhere('keterangan', 'like', '%' . $this->search . '%');
            })->when(!$this->showAll && !$this->search, function ($query) {
                $start = $this->tanggalAwal ? Carbon::parse($this->tanggalAwal)->startOfDay() : Carbon::today()->startOfDay();
                $end = $this->tanggalAkhir ? Carbon::parse($this->tanggalAkhir)->endOfDay() : Carbon::today()->endOfDay();
                if ($this->filterBulan) {
                    return $query->whereMonth('created_at', $this->filterBulan);
                }
                $query->whereBetween('created_at', [$start, $end]);
            });
    }

    protected function getFilteredServicesTanpaSearch()
    {
        return  Service::with(['kendaraan.pelanggan'])
            ->when(!$this->showAll && !$this->search, function ($query) {
                $start = $this->tanggalAwal ? Carbon::parse($this->tanggalAwal)->startOfDay() : Carbon::today()->startOfDay();
                $end = $this->tanggalAkhir ? Carbon::parse($this->tanggalAkhir)->endOfDay() : Carbon::today()->endOfDay();
                if ($this->filterBulan) {
                    return $query->whereMonth('created_at', $this->filterBulan);
                }
                $query->whereBetween('created_at', [$start, $end]);
            });
    }

    protected function getFilteredServicesPerminggu()
    {
        return Service::with(['kendaraan.pelanggan'])
            ->when(!$this->showAll && !$this->search, function ($query) {
                // Ambil 8 minggu ke belakang
                $start = $this->tanggalAwal ? Carbon::parse($this->tanggalAwal)->startOfDay() :  now()->subDays(6)->startOfDay(); // Mulai dari minggu ke-8 terakhir
                $end = $this->tanggalAkhir ? Carbon::parse($this->tanggalAkhir)->endOfDay() : now()->endOfDay(); // Akhir minggu ini

                if ($this->filterBulan) {
                    return $query->whereMonth('created_at', $this->filterBulan);
                }

                return $query->whereBetween('tanggal_mulai_service', [$start, $end]);
            });
    }


    public function getStatusChart()
    {
        $query = $this->getFilteredServicesTanpaSearch()->get();

        $statuses = [
            'dalam antrian',
            'dianalisis',
            'analisis selesai',
            'dalam proses',
            'selesai',
            'batal',
        ];

        $counts = [];
        foreach ($statuses as $status) {
            $counts[] = (clone $query)->where('status', $status)->count();
        }

        $colors = [
            'rgba(75, 192, 192, 0.6)',   // dalam antrian
            'rgba(255, 205, 86, 0.6)',   // dianalisis
            'rgba(54, 162, 235, 0.6)',   // analisis selesai
            'rgba(255, 159, 64, 0.6)',   // dalam proses (orange)
            'rgba(75, 192, 75, 0.6)',    // selesai (hijau)
            'rgba(255, 99, 71, 0.6)',    // batal (merah)
        ];

        $borderColors = array_map(function ($color) {
            return str_replace('0.6', '1', $color);
        }, $colors);

        return [
            'labels' => $statuses,
            'datasets' => [
                [
                    'data' => $counts,
                    'backgroundColor' => $colors,
                    'borderColor' => $borderColors,
                    'borderWidth' => 1,
                ]
            ]
        ];
    }

    protected function formatEstimasiWaktu($waktu)
    {
        [$jam, $menit, $detik] = array_pad(explode(':', $waktu ?? '00:00:00'), 3, 0);

        $jam = (int) $jam;
        $menit = (int) $menit;

        $output = [];
        if ($jam > 0) $output[] = "{$jam} jam";
        if ($menit > 0) $output[] = "{$menit} menit";

        return $output ? implode(' ', $output) : '0 menit';
    }


    public function getJumlahServicePerHariLineChart()
    {

        if ($this->filterBulan) {
            // Jika filter bulan dipilih, ambil awal dan akhir bulan tersebut
            $startDate = Carbon::createFromDate(null, $this->filterBulan, 1)->startOfMonth();
            $endDate = Carbon::createFromDate(null, $this->filterBulan, 1)->endOfMonth();
        } else {
            // Kalau tidak, pakai range berdasarkan tanggalAwal dan tanggalAkhir, atau default 7 hari terakhir
            $startDate = $this->tanggalAwal
                ? Carbon::parse($this->tanggalAwal)->startOfDay()
                : now()->subDays(6)->startOfDay();

            $endDate = $this->tanggalAkhir
                ? Carbon::parse($this->tanggalAkhir)->endOfDay()
                : now()->endOfDay();
        }

        $result = $this->getFilteredServicesPerminggu()
            ->whereBetween('tanggal_mulai_service', [$startDate, $endDate])
            ->selectRaw('DATE(tanggal_mulai_service) as tanggal, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->pluck('jumlah', 'tanggal')
            ->all(); // Konversi ke array

        $labels = [];
        $data = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $tanggal = $date->toDateString();
            $hari = $date->locale('id')->isoFormat('dddd');
            $labels[] = "$hari, " . $date->format('d M'); // Format lebih singkat, misal: Senin, 08 Jun
            $data[] = $result[$tanggal] ?? 0;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Service',
                    'data' => $data,
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.1)', // Sedikit transparan
                    'borderWidth' => 2,
                    'pointBackgroundColor' => 'rgba(54, 162, 235, 1)',
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                    'fill' => true,
                    'tension' => 0.3,
                ]
            ],
        ];
    }



    public function render()
    {
        $this->emitChartData();
        $services = $this->getFilteredServices()
            ->orderBy('tanggal_mulai_service', 'desc')
            ->paginate($this->perPage);

        foreach ($services as $service) {
            if (!isset($this->statuses[$service->id])) {
                $this->statuses[$service->id] = $service->status;
            }
        }

        return view('livewire.service.index', compact('services'), [
            'chartStatusService' => $this->getStatusChart(),
            'chartJumlahService' => $this->getJumlahServicePerHariLineChart(),
        ]);
    }
}
