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
        $validStatuses = ['dalam antrian', 'dianalisis', 'analisis selesai', 'dalam proses', 'selesai', 'batal'];

        if (!isset($this->statuses[$id]) || !in_array($this->statuses[$id], $validStatuses)) {
            session()->flash('error', 'Status tidak valid.');
            return;
        }

        $newStatus = $this->statuses[$id];

        // Siapkan data update
        $dataUpdate = ['status' => $newStatus];

        // Jika statusnya selesai, isi tanggal_selesai_service dengan tanggal sekarang (waktu Indonesia)
        if ($newStatus === 'selesai') {
            // Set timezone sesuai WIB (Jakarta)
            $tanggalSelesai = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
            $dataUpdate['tanggal_selesai_service'] = $tanggalSelesai;
        } else {
            // Jika status selain selesai, bisa kosongkan tanggal selesai atau biarkan tetap
            $dataUpdate['tanggal_selesai_service'] = null;
        }

        $updated = Service::where('id', $id)->update($dataUpdate);

        if ($updated) {
            // Ambil data service beserta relasi montir
            $service = Service::with('montir')->find($id);

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

            // Simpan riwayat status di tabel status_services
            StatusService::create([
                'service_id' => $service->id,
                'kode_service' => $service->kode_service,
                'status' => $newStatus,
                'keterangan' => $keterangan,
                'changed_at' => Carbon::now('Asia/Jakarta'),
            ]);

            session()->flash('success', 'Status berhasil diperbarui.');
        } else {
            session()->flash('error', 'Data service tidak ditemukan atau gagal diperbarui.');
        }
    }
}
