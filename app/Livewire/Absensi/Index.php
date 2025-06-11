<?php

namespace App\Livewire\Absensi;

use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;


#[Title('Absensi Hari Ini')]
class Index extends Component
{
    public function render()
    {
        $today = Carbon::today()->toDateString();

        // Ambil karyawan yang terkait dengan user yang sedang login
        $user = Auth::user();
        $karyawan = Karyawan::where('user_id', $user->id)->firstOrFail();

        // Kalau tidak ada data karyawan, return kosong
        if (!$karyawan) {
            $absensis = collect(); // koleksi kosong
        } else {
            $absensis = Absensi::where('tanggal', $today)
                ->where('karyawan_id', $karyawan->id)
                ->orderBy('jam_masuk', 'asc')
                ->get();
        }

        return view('livewire.absensi.index', compact('absensis'));
    }
}
