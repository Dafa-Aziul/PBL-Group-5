<div>
    <div class="container-fluid py-5" style="background-color:#373390; ">
        <div class="container" style="max-width: 900px;">
            <div class="row align-items-center">
                <!-- Kolom Teks -->
                <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
                    <h4 class="text-white display-4 mb-3 wow fadeInDown" data-wow-delay="0.1s">Lacak Service!

                    </h4>
                    <p class="text-white mb-3">
                        Pantau status kendaraanmu secara real-time, tanpa repot — cukup masukkan nomor polisi atau kode
                        service!
                    </p>
                    {{-- <ol
                        class="breadcrumb d-flex justify-content-center justify-content-md-start mb-0 wow fadeInDown mt-3"
                        data-wow-delay="0.3s">
                        <li class="breadcrumb-item"><a href="/" class="text-white text-info">Beranda</a></li>
                        <li class="breadcrumb-item active text-primary">Layanan</li>
                    </ol> --}}
                </div>

                <!-- Kolom Gambar -->
                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/asset/illustraci-lacak.png') }}" alt="Ilustrasi Layanan"
                        class="img-fluid wow fadeInUp" data-wow-delay="0.2s" style="max-height: 300px;">
                </div>
            </div>
        </div>
    </div>


    <div class="container my-5">
        <div class="text-center mb-4">
            <h2 class="text-primary">Lacak Status Service</h2>
            <p>Masukkan nomor polisi atau ID service kendaraan Anda</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form wire:submit.prevent="checkStatus">
                    <div class="input-group mb-3">
                        <input type="text" wire:model="input" class="form-control"
                            placeholder="Contoh: BA1234CD atau SRV001">
                        <button type="submit" class="btn btn-primary">Cek Status</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row justify-content-center">

            <div class="col-lg-6">
                @if ($submitted)
                    @if ($service)
                    <style>
                        .timeline-container {
                            position: relative;
                            margin-left: 30px;
                        }

                        .timeline-container::before {
                            content: '';
                            position: absolute;
                            left: 14px;
                            top: 0;
                            bottom: 0;
                            width: 2px;
                            background-color: #dee2e6;
                        }

                        .timeline-step {
                            position: relative;
                            display: flex;
                            align-items: flex-start;
                            margin-bottom: 30px;
                        }

                        .timeline-step::before {
                            content: none !important;
                            display: none !important;
                        }


                        .timeline-icon {
                            width: 28px;
                            height: 28px;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: white;
                            font-size: 14px;
                            z-index: 1;
                            margin-right: 16px;
                            flex-shrink: 0;
                        }

                        .timeline-icon.success {
                            background-color: #198754;
                        }

                        .timeline-icon.primary {
                            background-color: #0d6efd;
                        }

                        .timeline-icon.gray {
                            background-color: #adb5bd;
                        }

                        .timeline-content {
                            flex: 1;
                        }

                        .timeline-title {
                            font-weight: 600;
                            margin-bottom: 4px;
                            font-size: 16px;
                            text-transform: capitalize;
                        }

                        .timeline-desc {
                            font-size: 14px;
                            color: #6c757d;
                            margin-bottom: 4px;
                        }

                        .timeline-keterangan {
                            font-size: 14px;
                            color: #495057;
                            margin-top: 4px;
                        }
                    </style>
                    <div class="card mt-4 shadow-sm border-0 wow fadeInUp">
                        <div class="card-header bg-primary text-white d-flex align-items-center">
                            <i class="fas fa-stream me-2"></i>
                            <strong>Log Status Service</strong>
                        </div>

                        <div class="card-body">

                            {{-- Jika service ditemukan, tampilkan timeline --}}

                            <div class="timeline-container">
                                @php
                                $icons = [
                                'dalam antrian' => 'fas fa-check',
                                'dianalisis' => 'fas fa-tools',
                                'analisis selesai' => 'fas fa-clipboard-check',
                                'dalam proses' => 'fas fa-cogs',
                                'selesai' => 'fas fa-car',
                                'batal' => 'fas fa-times-circle'
                                ];

                                // Filter hanya status yang sudah dilewati dan sekarang
                                $filteredStatus = $statusHistory->filter(function ($step) use ($allStatus, $currentStatus) {
                                return array_search($step->status, $allStatus) <= array_search($currentStatus, $allStatus);
                                    })->reverse(); 
                                    @endphp 
                                    @foreach ($filteredStatus as $step) 
                                        @php $status=$step->status;
                                        $isActive = $status === $currentStatus;
                                        $isDone = array_search($status, $allStatus) < array_search($currentStatus, $allStatus);
                                            $iconClass=$icons[$status] ?? 'fas fa-circle' ; $badgeClass=$isDone ? 'success' :
                                            ($isActive ? 'primary' : 'gray' ); 
                                            
                                        @endphp 
                                        <div class="timeline-step">
                                            <div class="timeline-icon {{ $badgeClass }}">
                                                <i class="{{ $iconClass }}"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <p class="timeline-title">{{ $status }}</p>
                                                <p class="timeline-desc">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($step->created_at)->format('d M Y H:i') }}
                                                    @if ($step->service && $step->service->montir)
                                                    | <i class="bi bi-person"></i> {{ $step->service->montir->nama }}
                                                    @endif
                                                </p>
                                                <p class="timeline-keterangan">{{ $step->keterangan ?? '-' }}</p>
                                            </div>
                                        
                                         </div>
                                        
                                    @endforeach
                            </div>

                            
                        </div>



                    </div>
                    @else
                    <div class="alert alert-warning wow fadeInUp" data-wow-delay="0.2s">
                        <i class=" fas fa-exclamation-triangle me-1"></i>
                        Belum ada service tercatat.
                    </div>

                    @endif

                @endif

            </div>





        </div>

    </div>

</div>

</div>




















<!-- Simulasi JS Tracking -->
<script>
    function checkStatus() {
        const input = document.getElementById("serviceInput").value.trim().toUpperCase();
        const result = document.getElementById("resultArea");

        const dataTracking = {
            "BA1234CD": "Dalam Pengecekan",
            "BA5678EF": "Dalam Perbaikan",
            "SRV001": "Menunggu Suku Cadang",
            "SRV002": "Servis Selesai - Siap Diambil",
        };

        if (input === "") {
            result.className = "alert alert-warning";
            result.innerText = "Silakan masukkan nomor yang valid!";
            result.classList.remove("d-none");
            return;
        }

        if (dataTracking[input]) {
            result.className = "alert alert-success";
            result.innerHTML = `<strong>Status:</strong> ${dataTracking[input]}`;
        } else {
            result.className = "alert alert-danger";
            result.innerText = "Nomor tidak ditemukan. Silakan hubungi admin.";
        }
        result.classList.remove("d-none");
    }
</script>

</div>