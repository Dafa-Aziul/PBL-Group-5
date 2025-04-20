<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class jenisLayanan extends Model
{
    /** @use HasFactory<\Database\Factories\JenisLayananFactory> */
    use HasFactory, SoftDeletes;
    protected $table = 'jenis_layanans';
    protected $fillable = ['nama_layanan','estimasi_pengerjaan','jenis_kendaraan','harga','deskripsi'];
}
