<?php

namespace App\Models;

use App\Models\JenisKendaraan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Jasa extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $guarded = [];
    protected $table = 'jasas';
    protected $fillable = [
        'jenis_kendaraan_id',
        'kode',
        'nama_jasa',
        'estimasi',
        'harga',
        'keterangan',
    ];
    public function jenisKendaraan()
    {
        return $this->belongsTo(JenisKendaraan::class)->withTrashed();
    }

    public function scopeSearch($query, $value)
    {
        $query->where('jenis_kendaraan_id', 'like', "%{$value}%")
            ->orWhere('kode', 'like', "%{$value}%")
            ->orWhere('nama_jasa', 'like', "%{$value}%")
            ->orWhere('estimasi', 'like', "%{$value}%")
            ->orWhere('harga', 'like', "%{$value}%")
            ->orWhere('keterangan', 'like', "%{$value}%");
    }
}
