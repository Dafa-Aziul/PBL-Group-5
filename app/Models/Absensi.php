<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Absensi extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    protected $table = 'absensis';
    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'foto_masuk',
        'foto_keluar',
        'bukti_tidak_hadir',
        'status',
        'keterangan'
    ];

    public function scopeSearch($query, $value)
    {
        $query->where(function ($q) use ($value) {
            $q->where('karyawan_id', 'like', "%{$value}%")
                ->orWhere('tanggal', 'like', "%{$value}%")
                ->orWhere('jam_masuk', 'like', "%{$value}%")
                ->orWhere('jam_keluar', 'like', "%{$value}%")
                ->orWhere('foto_masuk', 'like', "%{$value}%")
                ->orWhere('foto_keluar', 'like', "%{$value}%")
                ->orWhere('bukti_tidak_hadir', 'like', "%{$value}%")
                ->orWhere('status', 'like', "%{$value}%")
                ->orWhere('keterangan', 'like', "%{$value}%");
        })->orWhereHas('karyawan', function ($q) use ($value) {
            $q->where('nama', 'like', "%{$value}%");
        });
    }


    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
