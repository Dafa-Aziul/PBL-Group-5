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

    public function render()
    {
        $services = Service::with(['kendaraan.pelanggan'])
            ->where(function ($query) {
                $query->where('kode_service', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kendaraan', function ($q) {
                        $q->where('no_polisi', 'like', '%' . $this->search . '%')
                            ->orWhere('model_kendaraan', 'like', '%' . $this->search . '%')
                            ->orWhereHas('pelanggan', function ($sub) {
                                $sub->where('nama', 'like', '%' . $this->search . '%');
                            });
                    })
                    ->orWhere('keterangan', 'like', '%' . $this->search . '%');
            })
            ->when(!$this->showAll, function ($query) {
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

        return view('livewire.service.index', compact('services'));
    }
}
