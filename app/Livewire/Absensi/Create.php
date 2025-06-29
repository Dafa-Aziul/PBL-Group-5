<?php

namespace App\Livewire\Absensi;

use App\Livewire\Forms\AbsensiForm;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Mencatat Absensi')]
class Create extends Component
{

    use WithFileUploads;
    public $karyawan_id;
    public $karyawan;
    public $absensi;
    public AbsensiForm $form;
    public $type;

    public function getTitle()
    {
        return match ($this->type) {
        return match ($this->type) {
            'check-in' => 'Check In',
            'check-out' => 'Check Out',
            default => 'Bukti Izin & Sakit',
        };
    }

    public function mount($id, $type)
    {
        $this->karyawan_id = $id;
        $this->karyawan = Karyawan::findOrFail($id);
        $this->absensi = Absensi::where('karyawan_id', $this->karyawan->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();
        $this->type = $type;

        // Validasi WiFi bengkel (IP lokal)
        $getRealIp = function () {
            $realIp = getHostByName(gethostname());
            if ($realIp === '127.0.0.1') {
                $realIp = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            }
            return $realIp;
        };

        $ip = $getRealIp();
        $getRealIp = function () {
            $realIp = getHostByName(gethostname());
            if ($realIp === '127.0.0.1') {
                $realIp = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            }
            return $realIp;
        };

        $ip = $getRealIp();
        $prefix = env('BENGKEL_WIFI_PREFIX');
        Log::info('Client IP: ' . $ip);
        Log::info('Prefix: ' . $prefix);

        if (!str_starts_with($ip, $prefix)) {
        if (!str_starts_with($ip, $prefix)) {
            abort(403, 'Absensi hanya bisa dilakukan di jaringan WiFi bengkel.');
        }




        $today = now()->toDateString();
        $user = Auth::user();
        $karyawanId = $user?->karyawans?->id;

        if (!$karyawanId) return;
    }


    private function getStatusByTime(): string
    {
        $now = now();

        if ($this->type === 'check-in') {
            $batasMasuk = now()->setTime(8, 0);
            return $now->greaterThan($batasMasuk) ? 'terlambat' : 'hadir';
        }

        if ($this->type === 'check-out') {
            $batasKeluar = now()->setTime(17, 0);

            // Ambil absensi hari ini
            $absensiHariIni = Absensi::where('karyawan_id', $this->karyawan_id)
                ->whereDate('tanggal', $now->toDateString())
                ->first();

            // if ($now->greaterThanOrEqualTo($batasKeluar)) {
            //     return 'lembur';
            // }
            // if ($now->greaterThanOrEqualTo($batasKeluar)) {
            //     return 'lembur';
            // }

            return $absensiHariIni && $absensiHariIni->status === 'terlambat' ? 'terlambat' : 'hadir';
        }


        return 'tidak diketahui';
    }



    public function submit()
    {
        $today = Carbon::today();

        // Cek apakah sudah check-in
        $absensiHariIni = Absensi::where('karyawan_id', $this->karyawan_id)
            ->whereDate('tanggal', $today)
            ->whereNotNull('jam_masuk') // pastikan hanya cek yang sudah check-in
            ->first();

        if ($this->type === 'check-in') {
            if ($absensiHariIni) {
                session()->flash('error', 'Anda sudah melakukan check-in hari ini.');
                return redirect()->route('absensi.view');
            }

            $this->form->status = $this->getStatusByTime();
            $absensiTidakHadir = Absensi::where('karyawan_id', $this->karyawan_id)
                ->whereDate('tanggal', now()->toDateString())
                ->whereIn('status', ['izin', 'sakit'])
                ->exists();

            if ($absensiTidakHadir) {
                session()->flash('error', 'Karyawan sudah mengisi ketidakhadiran hari ini.');
                return redirect()->route('absensi.view');
            }
        }

        if ($this->type === 'check-out') {
            // Belum check-in → tidak boleh check-out
            if (!$absensiHariIni || !$absensiHariIni->jam_masuk) {
                session()->flash('error', 'Anda belum melakukan check-in hari ini.');
                return redirect()->route('absensi.view');
            }

            // Sudah check-out → tidak boleh dua kali
            if ($absensiHariIni->jam_keluar) {
                session()->flash('error', 'Anda sudah melakukan check-out hari ini.');
                return redirect()->route('absensi.view');
            }

            // Belum masuk waktu pulang → tidak boleh check-out
            $waktuSekarang = now();
            $waktuPulang = now()->setTime(17, 0); // ← atur sesuai aturan jam pulang
            if ($waktuSekarang->lt($waktuPulang)) {
                session()->flash('error', 'Check out hanya bisa dilakukan setelah jam pulang (17:00).');
                return redirect()->route('absensi.view');
            }
        }

        // Set tanggal hari ini
        $this->form->tanggal = $today;
        $data = $this->form->validate();
        $data['karyawan_id'] = $this->karyawan_id;
        // dd($data);
        // $data['status'] = $this->absensi->status;
        $data['tanggal'] = $today;



        if ($this->type === 'tidak-hadir') {
            $absensiHariIni = Absensi::where('karyawan_id', $this->karyawan_id)
                ->whereDate('tanggal', $today)
                ->first();

            if ($absensiHariIni) {
                session()->flash('error', 'Data ketidakhadiran sudah diajukan hari ini.');
                return redirect()->route('absensi.view');
            }

            if (!in_array($this->form->status, ['izin', 'sakit'])) {
                session()->flash('error', 'Status tidak hadir harus berupa izin atau sakit.');
                return redirect()->route('absensi.view');
            }

            // Simpan file ke dua kolom jika ada foto
            if ($this->form->bukti_tidak_hadir) {
                $data['bukti_tidak_hadir'] = $this->form->bukti_tidak_hadir->store('absensi/foto_tidak_hadir', 'public');
            }
            Absensi::create($data);
        }

        if ($this->type === 'check-in') {
            $data['jam_masuk'] = now()->format('H:i');
            $data['status'] = $this->getStatusByTime();
            if ($data['foto_masuk']) {
                $path = $data['foto_masuk']->store('absensi/foto_masuk', 'public');
                $data['foto_masuk'] = basename($path);
            }
            Absensi::create($data);
        } elseif ($this->type === 'check-out') {
            // Validasi sudah dilakukan sebelumnya: absensiHariIni tersedia dan belum jam_keluar

            $statusCheckIn = $absensiHariIni->status;
            //$statusCheckOut = $this->getStatusByTime(); // status berdasarkan jam keluar
            //$statusCheckOut = $this->getStatusByTime(); // status berdasarkan jam keluar

            // Default: status tetap seperti check-in
            $finalStatus = $statusCheckIn;

            // Jika check-in tidak terlambat tapi pulang lembur, maka ubah jadi 'lembur'
            // if ($statusCheckIn === 'hadir' && $statusCheckOut === 'lembur') {
            //     $finalStatus = 'lembur';
            // }
            if ($statusCheckIn === 'terlambat') {
            // if ($statusCheckIn === 'hadir' && $statusCheckOut === 'lembur') {
            //     $finalStatus = 'lembur';
            // }
            if ($statusCheckIn === 'terlambat') {
                $finalStatus = 'terlambat';
                // $keterangan = 'Karyawan lembur saat pulang pukul ' . now()->format('H:i');
                // $keterangan = 'Karyawan lembur saat pulang pukul ' . now()->format('H:i');
            }

            // Siapkan data yang akan di-update
            $updateData = [
                'jam_keluar' => now()->format('H:i'),
                'status' => $finalStatus,
            ];

            if (isset($keterangan)) {
                $updateData['keterangan'] = $keterangan;
            }

            // Simpan foto keluar jika ada
            if ($data['foto_keluar']) {
                $updateData['foto_keluar'] = $data['foto_keluar']->store('absensi/foto_keluar', 'public');
            }

            // Update absensi hari ini
            $absensiHariIni->update($updateData);

            session()->flash('success', 'Check out berhasil disimpan.');
            return redirect()->route('absensi.view');
        }





        // dd($data);
        //dd($this->type); // Pastikan nilainya benar-benar 'tidak hadir'
        // Simpan data check-in
        // Absensi::create($data);

        session()->flash('success', 'Absensi berhasil disimpan.');
        return redirect()->route('absensi.view');
    }



    public function render()
    {
        return view('livewire.absensi.create');
    }
}
