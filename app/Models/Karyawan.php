<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Karyawan extends Model
{
    use HasFactory, Notifiable;

    // Kolom-kolom yang boleh diisi secara massal
    protected $fillable = [
        'user_id',
        'nama',
        'jabatan',
        'no_hp',
        'alamat',
        'tgl_masuk',
        'status',
        'foto',
    ];

    // Cast otomatis untuk kolom tanggal
    protected $casts = [
        'tgl_masuk' => 'date',
    ];

    // Relasi: Karyawan memiliki banyak Konten
    public function kontens()
    {
        return $this->hasMany(Konten::class, 'penulis_id');
    }

    // Relasi: Karyawan milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}