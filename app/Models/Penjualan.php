<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualans';

    protected $fillable = [
        'transaksi_id',
        'sparepart_id',
        'jumlah',
        'harga',
        'sub_total',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'sparepart_id')->withTrashed();;
    }
}
