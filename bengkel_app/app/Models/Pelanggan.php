<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    /** @use HasFactory<\Database\Factories\PelangganFactory> */
    use HasFactory;
    protected $fillable = [
        'nama_pelanggan',
        'email',
        'no_telp',
        'alamat',
        'no_polisi',
        'jenis_kendaraan',
        'model',
        'ket',
    ];
}
