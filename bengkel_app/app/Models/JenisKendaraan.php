<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKendaraan extends Model
{
    /** @use HasFactory<\Database\Factories\JenisKendaraanFactory> */
    use HasFactory;
    protected $primaryKey = 'id_jenis';
    protected $fillable = ['nama_jenis', 'merk', 'model', 'tahun', 'deskripsi'];
}
