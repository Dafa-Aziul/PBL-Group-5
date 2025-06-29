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
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
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

        .divider {
            border: none;
            border-top: 2px solid #000;
            margin: 10px 0 15px;
        }

        .invoice-title {
            font-size: 18px;
            font-weight: bold;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .invoice-number {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .total-section {
            font-weight: bold;
        }

        .signature {
            float: right;
            width: 200px;
            text-align: center;
        }

        .currency-cell {
            text-align: right;
            padding-right: 5px;
            position: relative;
        }

        .currency-cell span.currency {
            position: absolute;
            left: 5px;
        }

        .currency-cell span.value {
            display: block;
            width: 100%;
            text-align: right;
        }

        .kop-header-table {
            width: 100%;
            table-layout: fixed;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .kop-header-table td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        .kop-logo-cell {
            width: 20%;
            padding-left: 10px;
        }

        .kop-logo-cell img {
            width: 110px;
            height: auto;
            display: block;
        }

        .kop-text-cell {
            width: 80%;
            padding: 0 10px;
            text-align: center;
            font-size: 11px;
            line-height: 1.5;
        }

        .kop-text-cell .kop-title {
            font-size: 31px;
            font-weight: normal;
            margin: 0 0 4px 0;
            line-height: 1.2;
        }

        .kop-text-cell .kop-subtitle {
            font-size: 10.5px;
            margin: 0;
            line-height: 1.4;
        }

        .kop-text-cell .kop-contact {
            margin-top: 3px;
            font-style: italic;
            font-size: 10px;
            color: #1a237e;
        }
    </style>
</head>

<body>
    <table class="kop-header-table">
        <tr>
            <td class="kop-logo-cell">
                <img src="{{ public_path('images/kopcv.jpg') }}" alt="Logo">
            </td>
            <td class="kop-text-cell">
                <h1 class="kop-title">CV. RAZKA PRATAMA</h1>
                <p class="kop-subtitle">Menjual suku cadang dan aksesoris mobil, perdagangan besar,</p>
                <p class="kop-subtitle">Menyewakan mesin, peralatan konstruksi dan teknik sipil</p>
                <p class="kop-contact">
                    Jl. Cimanggis Permai Blok B3 No. 1A - Telp. 08111870588, 08111870581  Email: <i>cv.razkapratama@gmail.com</i>
                </p>
            </td>
        </tr>
    </table>

    <hr class="divider">

    <div class="invoice-header">
        <div class="invoice-title">INVOICE</div>
        <div class="invoice-number">No. {{ $transaksi->kode_transaksi }}</div>
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
            <td colspan="4">Kepada Yth.</td>
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
            <td colspan="3"></td>
            <td colspan="2">No.Polisi</td>
            <td>: {{ $transaksi->serviceDetail->service->no_polisi ?? '-' }}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3"></td>
            <td colspan="2">Tipe Kendaraan</td>
            <td>: {{ $transaksi->serviceDetail->service->tipe_kendaraan ?? '-' }}</td>
        </tr>
    </table>

    @if ($transaksi->jenis_transaksi === 'service')
    @php
    $jasas = $transaksi->serviceDetail ? $transaksi->serviceDetail->service->jasas : collect();
    $totalJasa = $jasas->sum(fn($jasa) => $jasa->harga ?? 0);

    $spareparts = $transaksi->serviceDetail ? $transaksi->serviceDetail->service->spareparts : collect();
    $totalSparepart = $spareparts->sum(fn($sp) => $sp->sub_total ?? 0);

    $diskonPersen = $transaksi->diskon ?? 0;
    $diskonNominal = ($diskonPersen / 100) * ($transaksi->sub_total ?? 0);
    $subtotalSetelahDiskon = ($transaksi->sub_total ?? 0) - $diskonNominal;
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
                <td colspan="7">Sparepart / Oli</td>
            </tr>
            @foreach ($spareparts as $index => $sp)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $sp->sparepart->kode ?? '-' }}</td>
                <td>{{ $sp->sparepart->nama }}</td>
                <td class="text-center">{{ $sp->jumlah ?? '-' }}</td>
                <td class="text-center">{{ $sp->sparepart->satuan ?? '-' }}</td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($sp->harga ?? 0, 0, ',', '.') }}</span>
                </td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($sp->sub_total ?? 0, 0, ',', '.') }}</span>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="6" class="text-right"><strong>Total Part</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($totalSparepart ?? 0, 0, ',', '.') }}</span>
                </td>
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
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($jasa->harga ?? 0, 0, ',', '.') }}</span>
                </td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($jasa->harga ?? 0, 0, ',', '.') }}</span>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="6" class="text-right"><strong>Total Jasa</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($totalJasa ?? 0, 0, ',', '.') }}</span>
                </td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Sub Total</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($transaksi->sub_total ?? 0, 0, ',', '.') }}</span>
                </td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Diskon ({{ number_format($diskonPersen, 0, ',', '.')
                        }}%)</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($diskonNominal, 0, ',', '.') }}</span>
                </td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Subtotal Setelah Diskon</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($subtotalSetelahDiskon, 0, ',', '.') }}</span>
                </td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>PPN 11%</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($ppn, 0, ',', '.') }}</span>
                </td>
            </tr>

            <tr class="total-section">
                <td colspan="6" class="text-right"><strong>Grand Total</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($grandTotal, 0, ',', '.') }}</span>
                </td>
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
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($sp->harga ?? 0, 0, ',', '.') }}</span>
                </td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($sp->sub_total ?? 0, 0, ',', '.') }}</span>
                </td>
            </tr>
            @endforeach

            <!-- RINGKASAN -->
            <tr>
                <td colspan="6" class="text-right"><strong>Total Part</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($totalSparepart, 0, ',', '.') }}</span>
                </td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Sub Total</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($subTotal, 0, ',', '.') }}</span>
                </td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Diskon ({{ number_format($diskonPersen, 0, ',', '.')
                        }}%)</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($diskonNominal, 0, ',', '.') }}</span>
                </td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Subtotal Setelah Diskon</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($subtotalSetelahDiskon, 0, ',', '.') }}</span>
                </td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>PPN 11%</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($ppn, 0, ',', '.') }}</span>
                </td>
            </tr>

            <tr>
                <td colspan="6" class="text-right"><strong>Grand Total</strong></td>
                <td class="currency-cell">
                    <span class="currency">Rp</span>
                    <span class="value">{{ number_format($grandTotal, 0, ',', '.') }}</span>
                </td>
            </tr>
        </tbody>
    </table>
    @endif

    <div class="text-center">
        <div class="signature">
            <p><strong>Hormat Kami,</strong></p>
            <br><br><br>
            <p>(____________________)</p>
        </div>
    </div>
    <p><strong>Status Pembayaran:</strong> {{ ucfirst($transaksi->status_pembayaran) }}</p>

    <p><strong>Catatan service selanjutnya :</strong> {{ ucfirst($transaksi->ket) }}</p>

    {{-- <p style="text-align: center;">~ Terima kasih atas kunjungannya ~</p> --}}
</body>

</html>