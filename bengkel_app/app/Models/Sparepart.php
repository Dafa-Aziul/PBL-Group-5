<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sparepart extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $table = 'spareparts';
    protected $fillable = [
        'nama',
        'harga',
        'merk',
        'satuan',
        'stok',
        'model_kendaraan',
        'keterangan',
    ];

}
