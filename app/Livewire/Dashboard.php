<?php

namespace App\Livewire;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Sparepart;
use App\Models\Transaksi;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;


#[Title('Dashboard - SiBeMo')]
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

    protected function getFilteredTransaksisTanpaSearch()
    {
        return Transaksi::with(['kasir', 'pelanggan', 'pembayarans']);
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

    public function emitChartData()
    {
        $this->dispatch('chart-pendapatan-updated', chartData: $this->getPendapatanPerBulanChartData());
        $this->dispatch('chart-absensi-updated', chartData: $this->getAllStatusChartData());
    }
    public function render()
    {
        $this->emitChartData();
        //untuk card absensi (admin-mekanik)
        $today = Carbon::today()->toDateString();

        // // Ambil karyawan yang terkait dengan user yang sedang login
        $user = Auth::user();
        $karyawan = Karyawan::where('user_id', $user->id)->first();

        // Kalau tidak ada, atur default kosong
        $transaksis = collect();
        if ($karyawan) {
            $transaksis = Absensi::where('tanggal', $today)
                ->where('karyawan_id', $karyawan->id)
                ->orderBy('jam_masuk', 'asc')
                ->get();
        }

        $spareparts = Sparepart::where('stok', '<=', 10)->get();
        $stokmenipis = $spareparts->count();

        // untuk card absensi (owner)
        $chartStatusAbsensi = $this->getAllStatusChartData();
        $belumAbsen = $this->getBelumAbsen(7, 0); // jam 10:00

        $jumlahTransaksi = $this->getFilteredTransaksisTanpaSearch()
            ->whereDate('created_at', today())
            ->count();

        $service = $this->getFilteredTransaksisTanpaSearch()
            ->where('jenis_transaksi', 'service')
            ->whereDate('created_at', today())
            ->count();

        $penjualan = $this->getFilteredTransaksisTanpaSearch()
            ->where('jenis_transaksi', 'penjualan')
            ->whereDate('created_at', today())
            ->count();

        // dd($chartStatusAbsensi);

        return view(
            'livewire.dashboard',
            compact('transaksis', 'spareparts', 'stokmenipis', 'jumlahTransaksi', 'service', 'penjualan', 'chartStatusAbsensi', 'belumAbsen'),
            [
                'chartPendapatanBulanan' => $this->getPendapatanPerBulanChartData(),
            ]
        );
    }
}
