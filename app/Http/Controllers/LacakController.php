<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\StatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Jobs\ProcessTrackingDataJob;
use Illuminate\Support\Facades\Cache;

class LacakController extends Controller
{
    /**
     * GET /api/tracking/{kode_service}
     *
     * @param  string  $kode_service
     * @return JsonResponse
     */


    public function index(): JsonResponse
    {
        $services = Service::with('statuses')->get(); // Pastikan relasi 'statuses' ada di model
        return response()->json([
            'status' => 'success',
            'data' => $services
        ]);
    }

    public function track(string $kode_service): JsonResponse
    {
        $kode_service = strtoupper(trim($kode_service));

        $service = Service::with('montir')->where('kode_service', $kode_service)->first();

        if (! $service) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Nomor tidak ditemukan. Silakan hubungi admin.',
            ], 404);
        }

        $history = StatusService::where('service_id', $service->id)
            ->orderBy('changed_at')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'service'       => $service,
                'currentStatus' => optional($history->last())->status,
                'statusHistory' => $history,
            ],
        ]);
        // $kode_service = strtoupper(trim($kode_service));
        // $cacheKey = "tracking_{$kode_service}";

        // // 1. Kalau sudah diproses → langsung balikin hasilnya
        // if (Cache::has($cacheKey)) {
        //     return response()->json([
        //         'status' => 'success',
        //         'data' => Cache::get($cacheKey),
        //     ]);
        // }

        // // 2. Kalau belum ada → dispatch job, kasih respon 202 Accepted
        // ProcessTrackingData::dispatch($kode_service);

        // return response()->json([
        //     'status'  => 'processing',
        //     'message' => 'Sedang mengambil data tracking, silakan tunggu beberapa detik...',
        // ], 202);
    }
}
