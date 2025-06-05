<?php

namespace App\Livewire\Service;

use App\Livewire\Kendaraan\RiwayatService;
use App\Models\Service;
use App\Models\StatusService;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';

    public $tanggalAwal;
    public $tanggalAkhir;
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
            $namaMontir = $service->montir->nama ?? 'montir';

            $keterangan = match ($newStatus) {
                'dalam antrian'     => 'Service telah masuk ke dalam antrian.',
                'dianalisis'        => 'Service sedang dalam proses analisis oleh ' . $namaMontir . '.',
                'analisis selesai'  => 'Analisis telah selesai dilakukan oleh ' . $namaMontir . '.',
                'dalam proses'      => 'Service sedang dikerjakan oleh ' . $namaMontir . '.',
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

            session()->flash('success', 'Status berhasil diperbarui.');
        } else {
            session()->flash('error', 'Gagal memperbarui status service.');
        }
    }

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

    //chart jenis jasa
    public function getChartJasa()
    {
        $today = Carbon::today();

        $servicesHariIni = Service::with('jasas.jasa')
            ->whereDate('created_at', $today)
            ->get();

        $allJasas = $servicesHariIni->flatMap(function ($service) {
            return $service->jasas->map(function ($jasa) {
                return [
                    'nama_jasa' => $jasa->jasa->nama_jasa ?? 'Tidak Diketahui',
                    'jumlah' => $jasa->jumlah ?? 1,
                ];
            });
        });

        $grouped = collect($allJasas)
            ->groupBy('nama_jasa')
            ->map(fn($group) => $group->sum('jumlah'));

        return [
            'labels' => $grouped->keys()->toArray(),
            'data' => $grouped->values()->toArray(),
        ];
    }

    public function getChartStatus()
    {
        $today = Carbon::today();

        // Ambil semua service yang dibuat hari ini
        $servicesHariIni = Service::whereDate('created_at', $today)->get();

        // Group by kolom 'status' dan hitung jumlah tiap status
        $grouped = $servicesHariIni->groupBy('status')->map->count();

        return [
            'labels' => $grouped->keys()->toArray(),
            'data' => $grouped->values()->toArray(),
        ];
    }





    public function render()
    {
        $services = Service::with(['kendaraan.pelanggan'])
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
            })
            ->when(!$this->showAll && !$this->search, function ($query) {
                $start = $this->tanggalAwal ? Carbon::parse($this->tanggalAwal)->startOfDay() : Carbon::today()->startOfDay();
                $end = $this->tanggalAkhir ? Carbon::parse($this->tanggalAkhir)->endOfDay() : Carbon::today()->endOfDay();

                $query->whereBetween('created_at', [$start, $end]);
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        foreach ($services as $service) {
            if (!isset($this->statuses[$service->id])) {
                $this->statuses[$service->id] = $service->status;
            }
        }

        $today = Carbon::today();
        $chartJasa = $this->getChartJasa();
        $chartStatus = $this->getChartStatus();
        // dd($chartStatus);

        // Pastikan relasi dimuat
        $jumlah = Service::with(['spareparts'])->get();

        // Hitung jumlah jasa dari seluruh service
        $jumlahService = Service::whereDate('created_at', $today)->count();

        // Hitung jumlah sparepart yang digunakan hari ini
        $jumlahSparepart = $jumlah->sum(function ($service) use ($today) {
            return $service->spareparts
                ->filter(function ($sparepart) use ($today) {
                    return $sparepart->created_at->toDateString() === $today->toDateString();
                })
                ->sum('jumlah'); // gunakan count() kalau tidak ada kolom 'jumlah'
        });

        return view('livewire.service.index', compact(
            'services',
            'jumlahSparepart',
            'jumlahService',
            'chartJasa',
            'chartStatus'
        ));
    }
}
