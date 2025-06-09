<?php

namespace App\Livewire;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Sparepart;
use App\Models\Transaksi;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{

    public function getAllTransaksi()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Ambil semua transaksi dalam bulan ini
        $transaksi = Transaksi::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->whereIn('jenis_transaksi', ['penjualan', 'service'])
            ->get();

        $result = [];

        foreach ($transaksi as $item) {
            $mingguKe = intval(ceil(Carbon::parse($item->created_at)->day / 7));
            $key = $item->jenis_transaksi . '-' . $mingguKe;

            if (!isset($result[$key])) {
                $result[$key] = [
                    'jenis_transaksi' => $item->jenis_transaksi,
                    'minggu' => $mingguKe,
                    'jumlah' => 0,
                    'total' => 0,
                ];
            }

            $result[$key]['jumlah'] += 1;
            $result[$key]['total'] += $item->grand_total; // ganti sesuai kolom total di tabel
        }

        return array_values($result);
    }

    public function getAbsensiStatusChartData()
    {
        $today = Carbon::today()->toDateString();

        $data = Absensi::select('status')
            ->whereDate('tanggal', $today)
            ->groupBy('status')
            ->selectRaw('status, COUNT(*) as total')
            ->pluck('total', 'status');

        return [
            'labels' => $data->keys()->toArray(),
            'data' => $data->values()->toArray(),
        ];
    }

    public function getAllStatusChartData()
    {
        $today = Carbon::today()->toDateString();

        // Ambil semua data absensi untuk bulan itu
        $absensi = Absensi::with('karyawan')
            ->whereDate('tanggal', $today)
            ->get();

        // Status yang ingin ditampilkan
        $statusList = ['hadir', 'terlambat', 'izin', 'sakit', 'alpha', 'lembur'];

        $result = [];

        // Group by karyawan
        $grouped = $absensi->groupBy('karyawan_id');

        foreach ($grouped as $karyawanId => $items) {
            $karyawanNama = optional($items->first()->karyawan)->nama ?? 'Tidak diketahui';
            $statusCount = [];

            // Hitung per status
            foreach ($statusList as $status) {
                $statusCount[$status] = $items->where('status', $status)->count();
            }

            $result[] = [
                'nama' => $karyawanNama,
                'status' => $statusCount,
            ];
        }

        return $result;
    }

    public function getBelumAbsen($jam = 10, $menit = 0)
    {
        $now = Carbon::now();
        $jamBatas = Carbon::createFromTime($jam, $menit, 0);

        // Ambil semua karyawan
        $semuaKaryawan = Karyawan::all();

        // Ambil ID karyawan yang sudah absen hari ini
        $absenHariIni = Absensi::whereDate('created_at', Carbon::today())->pluck('karyawan_id')->toArray();

        // Filter: hanya tampilkan yang belum absen dan sudah lewat jam batas
        $belumAbsen = $semuaKaryawan->filter(function ($karyawan) use ($absenHariIni, $now, $jamBatas) {
            return !in_array($karyawan->id, $absenHariIni) && $now->greaterThan($jamBatas);
        });

        return $belumAbsen;
    }

    public function render()
    {

        //untuk card absensi (admin-mekanik)
        $today = Carbon::today()->toDateString();

        // // Ambil karyawan yang terkait dengan user yang sedang login
        $user = Auth::user();
        $karyawan = Karyawan::where('user_id', $user->id)->firstOrFail();
        $transaksis = Absensi::where('tanggal', $today)
            ->where('karyawan_id', $karyawan->id)
            ->orderBy('jam_masuk', 'asc')
            ->get();

        $spareparts = Sparepart::where('stok', '<', 10)->get();
        $stokmenipis = $spareparts->count();

        // untuk card absensi (owner)
        $chartStatus = $this->getAbsensiStatusChartData();
        $chartStatusAbsensi = $this->getAllStatusChartData();
        $belumAbsen = $this->getBelumAbsen(10, 0); // jam 10:00


        //untuk card transaksi
        $chartTransaksi = $this->getAllTransaksi();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $transaksiBulanIni = Transaksi::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get();

        $jumlahTransaksi = $transaksiBulanIni->count();
        $totalTransaksi = $transaksiBulanIni->sum('grand_total'); // sesuaikan nama kolom

        $avgPendapatan = $jumlahTransaksi > 0 ? $totalTransaksi / $jumlahTransaksi : 0;

        // dd($chartStatusAbsensi);

        return view('livewire.dashboard', compact('transaksis', 'spareparts', 'stokmenipis', 'chartTransaksi', 'jumlahTransaksi', 'totalTransaksi', 'avgPendapatan', 'chartStatus', 'chartStatusAbsensi','belumAbsen'));
    }
}
