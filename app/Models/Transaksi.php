<?php

namespace App\Models;

use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\ServiceDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'pelanggan_id',
        'kasir_id',
        'jenis_transaksi',
        'kode_transaksi',
        'sub_total',
        'pajak',
        'diskon',
        'total',
        'status_pembayaran',
        'keterangan',
    ];

    public function kasir()
    {
        return $this->belongsTo(Karyawan::class, 'kasir_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function serviceDetail()
    {
        return $this->hasOne(ServiceDetail::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
