<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Service extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    protected $table = 'services';
    protected $fillable = [
        'kode_service',
        'kendaraan_id',
        'montir_id',
        'no_polisi',
        'model_kendaraan',
        'odometer',
        'deskripsi_keluhan',
        'status',
        'estimasi_harga',
        'tanggal_mulai_service',
        'tanggal_selesai_service',
        'keterangan',
    ];

    public function scopeSearch($query, $value)
    {
        $query->where('kode_service', 'like', "%{$value}%")
            ->orWhere('no_polisi', 'like', "%{$value}%")
            ->orWhere('model_kendaraan', 'like', "%{$value}%")
            ->orWhere('odometer', 'like', "%{$value}%")
            ->orWhere('deskripsi_keluhan', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('estimasi_harga', 'like', "%{$value}%")
            ->orWhere('tanggal_mulai_service', 'like', "%{$value}%")
            ->orWhere('tanggal_selesai_service', 'like', "%{$value}%")
            ->orWhere('keterangan', 'like', "%{$value}%");
    }
}
