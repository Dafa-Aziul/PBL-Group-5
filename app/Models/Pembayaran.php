<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'transaksi_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'ket',
        'status_pembayaran',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
