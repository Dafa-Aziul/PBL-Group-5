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
            <p>Masukkan Kode Service kendaraan Anda</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form wire:submit.prevent="checkStatus">
                    <div class="input-group mb-3">
                        <input type="text" wire:model="input" class="form-control" placeholder="Contoh: SRV-1234">
                        <button type="submit" class="btn btn-primary">Cek Status</button>
                    </div>
                </form>

                @if ($status)
                <div class="alert alert-danger text-center">
                    <i class="fas fa-info-circle me-1"></i> {{ $status }}
                </div>
                @endif
            </div>
        </div>

        @if ($submitted && $service)
        <div class="row justify-content-center">
            <div class="col-lg-6 wow fadeInUp">
                {{-- CARD: Info Dasar Service --}}
                <div class="card mt-4 shadow-sm border-0">
                    <div class="card-header bg-primary text-white fs-6 fw-semibold">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Info Dasar Service</strong>

                    </div>
                    <div class="card-body fs-6">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <strong>Kode Service:</strong>
                                <span class="badge bg-light text-dark px-2 py-1">{{ $service[0]['kode_service'] ?? '-'
                                    }}</span>
                            </li>
                            <li class="mb-2">
                                <strong>No Polisi:</strong>
                                <span class="badge bg-info text-white px-2 py-1">{{ $service[0]['no_polisi'] ?? '-'
                                    }}</span>
                            </li>
                            <li class="mb-2">
                                <strong>Montir:</strong>
                                <span class="badge bg-success text-white px-2 py-1">{{ $service[0]['montir']['nama'] ??
                                    '-' }}</span>
                            </li>
                            <li class="mb-2">
                                <strong>Estimasi Waktu:</strong>
                                @php
                                $waktu = $service[0]['estimasi_waktu'] ?? null;
                                $jam = $menit = 0;
                                if ($waktu) {
                                $carbon = \Carbon\Carbon::parse($waktu);
                                $jam = (int) $carbon->format('G');
                                $menit = (int) $carbon->format('i');
                                }
                                @endphp
                                <span class="badge bg-warning text-dark px-2 py-1">
                                    @if ($waktu)
                                    @if ($jam > 0 && $menit > 0)
                                    {{ $jam }} jam {{ $menit }} menit
                                    @elseif ($jam > 0)
                                    {{ $jam }} jam
                                    @elseif ($menit > 0)
                                    {{ $menit }} menit
                                    @else
                                    -
                                    @endif
                                    @else
                                    -
                                    @endif
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- CARD: Log Status Service --}}
                <div class="card mt-4 shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-stream me-2"></i>
                        <strong>Log Status Service</strong>
                    </div>
                    <div class="card-body">

                        {{-- Timeline Styles --}}
                        <style>
                            .timeline-container {
                                position: relative;
                                margin-left: 0;

                            }

                            .timeline-container::before {
                                content: '';
                                position: absolute;
                                left: 14px;
                                /* posisi garis vertikal tetap */
                                top: 0;
                                bottom: 0;
                                width: 3px;
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

                        {{-- Timeline --}}
                        @php
                        $icons = [
                        'dalam antrian' => 'fas fa-check',
                        'dianalisis' => 'fas fa-tools',
                        'analisis selesai' => 'fas fa-clipboard-check',
                        'dalam proses' => 'fas fa-cogs',
                        'selesai' => 'fas fa-car',
                        'batal' => 'fas fa-times-circle'
                        ];

                        $filteredStatus = $statusHistory->filter(function ($step) use ($allStatus, $currentStatus) {
                        return array_search($step['status'], $allStatus) <= array_search($currentStatus, $allStatus);
                            })->reverse();
                            @endphp

                            <div class="timeline-container">
                                @foreach ($filteredStatus as $step)
                                @php
                                $status = $step['status'];
                                $isActive = $status === $currentStatus;
                                $isDone = array_search($status, $allStatus) < array_search($currentStatus, $allStatus);
                                    $iconClass=$icons[$status] ?? 'fas fa-circle' ; $badgeClass=$isDone ? 'success' :
                                    ($isActive ? 'primary' : 'gray' ); @endphp <div class="timeline-step">
                                    <div class="timeline-icon {{ $badgeClass }}">
                                        <i class="{{ $iconClass }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <p class="timeline-title">{{ $status }}</p>
                                        <p class="timeline-desc">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($step['changed_at'])->format('d M Y H:i') }}
                                        </p>
                                        <p class="timeline-keterangan">{{ $step['keterangan'] ?? '-' }}</p>
                                    </div>
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
