<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManajemenKonten extends Model
{
    // /** @use HasFactory<\Database\Factories\ManajemenKontenFactory> */
    // use HasFactory;

    use HasFactory;

    protected $table = 'ManajemenKonten';
    protected $primaryKey = 'id_konten';
    protected $fillable = [
        'judul', 'isi', 'kategori', 'tanggal_terbit',
        'gambar', 'video', 'status', 'penulis'
    ];
}
