<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AbsenGenarate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absen:genarate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek dan update absensi otomatis setiap hari jam 18.00';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Ambil semua karyawan
        $karyawans = Karyawan::all();

        foreach ($karyawans as $karyawan) {
            $karyawanId = $karyawan->id;

            // Jika belum absen sama sekali → dianggap alpha
            $sudahAbsen = Absensi::where('karyawan_id', $karyawanId)
                ->whereDate('tanggal', $today)
                ->exists();

            if (!$sudahAbsen) {
                Absensi::create([
                    'karyawan_id' => $karyawanId,
                    'tanggal' => $today,
                    'status' => 'alpha',
                    'keterangan' => 'Tidak melakukan absen masuk',
                ]);
            }

            // Jika sudah check-in tapi belum check-out → otomatis checkout
            $absenMasuk = Absensi::where('karyawan_id', $karyawanId)
                ->whereDate('tanggal', $today)
                ->whereNotNull('jam_masuk')
                ->whereNull('jam_keluar')
                ->first();

            if ($absenMasuk) {
                $absenMasuk->update([
                    'jam_keluar' => now()->format('H:i'),
                    'status' => 'hadir',
                    'keterangan' => 'Otomatis checkout karena tidak melakukan absen pulang',
                ]);
            }
        }

        Log::info('Absensi alpha otomatis berhasil dijalankan untuk tanggal ' . $today);
    }
}
