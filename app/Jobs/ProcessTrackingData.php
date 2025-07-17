<?php

namespace App\Jobs;

use App\Models\Service;
use App\Models\StatusService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ProcessTrackingData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $kodeService;

    /**
     * Create a new job instance.
     */
    public function __construct(string $kodeService)
    {
        $this->kodeService = strtoupper(trim($kodeService));
    }

    public function handle(): void
    {
        Log::info("⏳ [Job Start] Proses tracking kode: {$this->kodeService}");
        $service = Service::with('montir')->where('kode_service', $this->kodeService)->first();

        if (! $service) {
            return;
        }

        $history = StatusService::where('service_id', $service->id)
            ->orderBy('changed_at')
            ->get();

        // Simpan ke cache untuk digunakan Livewire / frontend
        Cache::put("tracking_{$this->kodeService}", [
            'service'       => $service,
            'currentStatus' => optional($history->last())->status,
            'statusHistory' => $history,
        ], now()->addMinutes(5));
        Log::info("✅ [Job Finish] Selesai tracking kode: {$this->kodeService}");
    }
}
