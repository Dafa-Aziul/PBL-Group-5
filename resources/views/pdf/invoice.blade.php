<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice No.{{ $transaksi->kode_transaksi }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            background-color: #e0e0e0;
        }

        .no-border td {
            border: none;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .invoice-title {
            font-size: 18px;
            font-weight: bold;
        }

        .invoice-number {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .company-name {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .total-section {
            font-weight: bold;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <div class="invoice-title"># INVOICE</div>
        <div class="invoice-number">No. 1197/INV/CV-RP/III/2025</div>
        {{-- <div class="company-name">Kapada Yth.<br>{{ $transaksi->pelanggan->nama ?? '-' }}</div> --}}
    </div>

    <table class="no-border">
        <tr>
            <td style="width: 25px;"></td>
            <td style="width: 70px;"></td>
            <td></td>
            <td style="width: 30px;"></td>
            <td style="width: 50px;"></td>
            <td style="width: 90px;"> </td>
            <td style="width: 90px;"></td>
        </tr>
        <tr>
            <td colspan="4">Kapada Yth.</td>
            <td colspan="2">Tanggal</td>
            <td>: {{ $transaksi->created_at->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"><strong>{{ $transaksi->pelanggan->nama ?? '-' }}</strong></td>
            <td colspan="2">Odometer</td>
            <td>: {{ $transaksi->serviceDetail->service->odometer ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"></strong></td>
            <td colspan="2">No.Polisi</td>
            <td>: {{ $transaksi->serviceDetail->service->no_polisi ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"></strong></td>
            <td colspan="2">Tipe Kendaraan</td>
            <td>: {{ $transaksi->serviceDetail->service->tipe_kendaraan ?? '-' }}</td>
        </tr>
    </table>
    @if ($transaksi->jenis_transaksi === 'service')
    @php
    // Ambil semua jasa dari relasi transaksi->serviceDetail->service->jasas
    $jasas = $transaksi->serviceDetail
    ? $transaksi->serviceDetail->service->jasas
    : collect();
    $totalJasa = $jasas->sum(fn($jasa) => $jasa->harga ?? 0);

    $spareparts = $transaksi->serviceDetail
    ? $transaksi->serviceDetail->service->spareparts
    : collect();
    $totalSparepart = $spareparts->sum(fn($sp) => $sp->sub_total ?? 0);
    @endphp

    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 70px;">Kode</th>
                <th>Keterangan</th>
                <th style="width: 30px;">Qty</th>
                <th style="width: 50px;">Satuan</th>
                <th style="width: 90px;">Harga Satuan</th>
                <th style="width: 90px;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <!-- SPAREPART SECTION -->
            <tr class="section-title">
                <td colspan="7">Sparepart / Oli</td>
            </tr>
            @foreach ($spareparts as $index => $sp)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $sp->sparepart->kode ?? '-' }}</td>
                <td>{{ $sp->sparepart->nama }}</td>
                <td class="text-center">{{ $sp->jumlah ?? '-' }}</td>
                <td class="text-center">{{ $sp->sparepart->satuan ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($sp->harga ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($sp->sub_total ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="6" class="text-right"><strong>Total Part</strong></td>
                <td class="text-right">Rp {{ number_format($totalSparepart ?? 0, 0, ',', '.') }}</td>
            </tr>

            <!-- JASA SECTION -->
            <tr class="section-title">
                <td colspan="7">Jasa</td>
            </tr>
            @foreach ($jasas as $index => $jasa)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $jasa->jasa->kode ?? '-' }}</td>
                <td>{{ $jasa->jasa->nama_jasa }}</td>
                <td class="text-center">-</td>
                <td class="text-center">-</td>
                <td class="text-right">Rp {{ number_format($jasa->harga ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($jasa->harga ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="6" class="text-right"><strong>Total Jasa</strong></td>
                <td class="text-right">Rp {{ number_format($totalJasa ?? 0, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Sub Total</strong></td>
                <td class="text-right">Rp {{ number_format($transaksi->sub_total ?? 0, 0, ',', '.') }}</td>
            </tr>

            @php
            $diskonPersen = $transaksi->diskon ?? 0;
            $diskonNominal = ($diskonPersen / 100) * ($transaksi->sub_total ?? 0);
            $subtotalSetelahDiskon = ($transaksi->sub_total ?? 0) - $diskonNominal;
            $ppn = round($subtotalSetelahDiskon * 0.11);
            $grandTotal = $subtotalSetelahDiskon + $ppn;
            @endphp

            <tr>
                <td colspan="6" class="text-right"><strong>Diskon ({{ number_format($diskonPersen, 0, ',', '.')
                        }}%)</strong></td>
                <td class="text-right">Rp {{ number_format($diskonNominal, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Subtotal Setelah Diskon</strong></td>
                <td class="text-right">Rp {{ number_format($subtotalSetelahDiskon, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>PPN 11%</strong></td>
                <td class="text-right">Rp {{ number_format($ppn, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Grand Total</strong></td>
                <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    @elseif ($transaksi->jenis_transaksi === 'penjualan')
    @php
    $spareparts = $transaksi->penjualanDetail ?? collect();
    $totalSparepart = $spareparts->sum(fn($sp) => $sp->sub_total ?? 0);

    $subTotal = $transaksi->sub_total ?? 0;
    $diskonPersen = $transaksi->diskon ?? 0;
    $diskonNominal = ($diskonPersen / 100) * $subTotal;
    $subtotalSetelahDiskon = $subTotal - $diskonNominal;
    $ppn = round($subtotalSetelahDiskon * 0.11);
    $grandTotal = $subtotalSetelahDiskon + $ppn;
    @endphp

    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 70px;">Kode</th>
                <th>Keterangan</th>
                <th style="width: 30px;">Qty</th>
                <th style="width: 50px;">Satuan</th>
                <th style="width: 90px;">Harga Satuan</th>
                <th style="width: 90px;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <!-- SPAREPART SECTION -->
            <tr class="section-title">
                <td colspan="7"><strong>Sparepart / Oli</strong></td>
            </tr>

            @foreach ($spareparts as $index => $sp)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $sp->sparepart->kode ?? '-' }}</td>
                <td>{{ $sp->sparepart->nama ?? '-' }}</td>
                <td class="text-center">{{ $sp->jumlah ?? '-' }}</td>
                <td class="text-center">{{ $sp->sparepart->satuan ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($sp->harga ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($sp->sub_total ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach

            <!-- RINGKASAN -->
            <tr>
                <td colspan="6" class="text-right"><strong>Total Part</strong></td>
                <td class="text-right">Rp {{ number_format($totalSparepart, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Sub Total</strong></td>
                <td class="text-right">Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Diskon ({{ number_format($diskonPersen, 0, ',', '.')
                        }}%)</strong></td>
                <td class="text-right">Rp {{ number_format($diskonNominal, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Subtotal Setelah Diskon</strong></td>
                <td class="text-right">Rp {{ number_format($subtotalSetelahDiskon, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>PPN 11%</strong></td>
                <td class="text-right">Rp {{ number_format($ppn, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Grand Total</strong></td>
                <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    @endif

    <div class="text-center">
        <div class="signature">
            <p><strong>Hormat Kami,</strong></p>
            <br><br><br>
            <p>(_______________________)</p>
        </div>
    </div>
    <p><strong>Status Pembayaran:</strong> {{ ucfirst($transaksi->status_pembayaran) }}</p>

    <p style="text-align: center;">~ Terima kasih atas kunjungannya ~</p>
</body>

</html>
