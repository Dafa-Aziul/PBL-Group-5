<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $transaksi = Transaksi::with([
            'pelanggan',
            'kasir',
            'penjualanDetail.sparepart',
            'serviceDetail.service.spareparts',
            'serviceDetail.service.jasas'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.invoice', compact('transaksi'))->setPaper('A4');

        return $pdf->stream('invoice_'  . $transaksi->kode_transaksi . '.pdf');
    }

    public function download($id)
    {
        $transaksi = Transaksi::with([
            'pelanggan',
            'kasir',
            'penjualanDetail.sparepart',
            'serviceDetail.service.spareparts',
            'serviceDetail.service.jasas'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.invoice', compact('transaksi'))->setPaper('A4');

        return $pdf->download('invoice_' . $transaksi->kode_transaksi . '.pdf');
    }
}
