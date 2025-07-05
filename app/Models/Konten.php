<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Konten extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'kontens';

    protected $fillable = [
        'id',
        'penulis_id',
        'isi',
        'judul',
        'kategori',
        'foto_konten',
        'video_konten',
        'status',
    ];

    /**
     * Relasi ke model Karyawan sebagai penulis
     */
    public function penulis()
    {
        return $this->belongsTo(Karyawan::class, 'penulis_id')->withTrashed();
    }
}
