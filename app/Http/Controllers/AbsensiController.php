<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class AbsensiController extends Controller
{
    public function exportPdf(Request $request)
    {
        Carbon::setLocale('id');
        $data = $this->getFilteredAbsensi($request);

        $tanggalList = $this->generateTanggalRange($request->start_date, $request->end_date);

        $groupedAbsensi = $data->mapWithKeys(function ($karyawan) use ($tanggalList) {
            $absenPerTanggal = $tanggalList->mapWithKeys(function ($tanggal) use ($karyawan) {
                $absen = $karyawan->absensis->firstWhere('tanggal', $tanggal);
                return [$tanggal => $absen?->status ?? '-'];
            });
            return [$karyawan->nama => $absenPerTanggal];
        });

        $pdf = Pdf::loadView('pdf.absensi', compact('tanggalList', 'groupedAbsensi'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('laporan_absensi.pdf');
    }

    public function showPdf(Request $request)
    {
        Carbon::setLocale('id');
        $data = $this->getFilteredAbsensi($request);

        $tanggalList = $this->generateTanggalRange($request->start_date, $request->end_date);

        $groupedAbsensi = $data->mapWithKeys(function ($karyawan) use ($tanggalList) {
            $absenPerTanggal = $tanggalList->mapWithKeys(function ($tanggal) use ($karyawan) {
                $absen = $karyawan->absensis->firstWhere('tanggal', $tanggal);
                return [$tanggal => $absen?->status ?? '-'];
            });
            return [$karyawan->nama => $absenPerTanggal];
        });

        $pdf = Pdf::loadView('pdf.absensi', compact('tanggalList', 'groupedAbsensi'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('preview_laporan_absensi.pdf');
    }

    protected function getFilteredAbsensi(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        return Karyawan::with(['absensis' => function ($query) use ($start, $end) {
            if ($start && $end) {
                $query->whereBetween('tanggal', [$start, $end]);
            }
        }])->get();
    }

    protected function generateTanggalRange($start, $end)
    {
        $tanggalList = collect();

        if ($start && $end) {
            $startDate = Carbon::parse($start);
            $endDate = Carbon::parse($end);

            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $tanggalList->push($date->format('Y-m-d'));
            }
        }

        return $tanggalList;
    }
}
