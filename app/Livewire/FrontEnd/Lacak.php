<?php

namespace App\Livewire\FrontEnd;

use App\Models\Service;
use App\Models\StatusService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;


#[Layout('layouts.guest')]
class Lacak extends Component
{
    public $input;
    public $status;
    public $currentStatus;
    public $allStatus = [
        'dalam antrian',
        'dianalisis',
        'analisis selesai',
        'dalam proses',
        'selesai',
        'batal'
    ];
    public $statusHistory = [];
    public $service;
    public $submitted = false;



    public function mount()
    {
        // $kode = 'Dolores numquam sunt'; // Ganti dengan kode service valid

        // $client = new Client([
        //     'base_uri' => 'http://127.0.0.1:8000',
        //     'timeout'  => 10.0,
        // ]);

        // try {
        //     $response = $client->request('GET', "/api/tracking/{$kode}");

        //     if ($response->getStatusCode() === 200) {
        //         $json = json_decode($response->getBody()->getContents(), true);
        //         $data = $json['data'];

        //         // Debug: Lihat hasilnya dulu
        //         dd($data);
        //     } else {
        //         dd("Status gagal: " . $response->getStatusCode());
        //     }
        // } catch (\Throwable $e) {
        //     dd("Error: " . $e->getMessage());
        // }
    }



    public function checkStatus()
    {
        $this->submitted = true;
        $this->reset(['status', 'currentStatus', 'statusHistory', 'service']);

        $kode = strtoupper(trim($this->input));

        if (empty($kode)) {
            $this->status = "Silakan masukkan kode service.";
            return;
        }

        try {
            $client = new Client(['base_uri' => 'http://127.0.0.1:8000']);
            $response = $client->request('GET', "/api/tracking/{$kode}");

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true)['data'];

                $this->service = collect([$data['service']]);
                $this->statusHistory = collect($data['statusHistory']);
                $this->currentStatus = $data['currentStatus'];
                $this->status = null;
            } else {
                $this->status = "Service tidak ditemukan.";
            }
        } catch (\Throwable $e) {
            $this->status = "Belum ada service tercatat, masukan kode service yang benar";
        }
    }

    public function render()
    {
        return view('livewire.front-end.lacak');
    }
}
