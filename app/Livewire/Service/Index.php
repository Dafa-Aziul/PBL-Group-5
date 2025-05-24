<?php

namespace App\Livewire\Service;

use App\Models\Service;
use App\Models\StatusService;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 5;
    public $search = '';

    // Array untuk menyimpan status masing-masing service by id
    public $statuses = [];

    public function render()
    {
        $services = Service::search($this->search)->paginate($this->perPage);

        // Pastikan setiap service punya nilai status di $statuses, supaya select terisi otomatis
        foreach ($services as $service) {
            if (!isset($this->statuses[$service->id])) {
                $this->statuses[$service->id] = $service->status;
            }
        }

        return view('livewire.service.index', [
            'services' => $services,
        ]);
    }

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

        if (!isset($this->statuses[$id]) || !array_key_exists($this->statuses[$id], $validStatuses)) {
            session()->flash('error', 'Status tidak valid.');
            return;
        }

        $newStatus = $this->statuses[$id];

        // Ambil data service sekarang
        $service = Service::with('montir')->find($id);
        if (!$service) {
            session()->flash('error', 'Data service tidak ditemukan.');
            return;
        }

        // Cek urutan status lama dan baru
        $oldStatus = $service->status;

        if (!isset($validStatuses[$oldStatus])) {
            $this->addError('statuses.' . $service->id, 'Status lama tidak dikenali.');
            return;
        }

        if ($validStatuses[$newStatus] < $validStatuses[$oldStatus]) {
            $this->addError('statuses.' . $service->id, 'Tidak bisa mengubah status ke tahap sebelumnya.');
            return;
        }


        // Siapkan data update
        $dataUpdate = ['status' => $newStatus];

        // Jika statusnya selesai, isi tanggal_selesai_service dengan tanggal sekarang (waktu Indonesia)
        if ($newStatus === 'selesai') {
            $tanggalSelesai = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
            $dataUpdate['tanggal_selesai_service'] = $tanggalSelesai;
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

            session()->flash('success', 'Status berhasil diperbarui.');
        } else {
            session()->flash('error', 'Gagal memperbarui status service.');
        }
    }
}
