<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\StatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    }
    
}
