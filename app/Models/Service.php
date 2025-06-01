<?php

namespace App\Models;

use App\Models\Karyawan;
use App\Models\Kendaraan;
use App\Models\ServiceDetail;
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
        'tipe_kendaraan',
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
            ->orWhere('tipe_kendaraan', 'like', "%{$value}%")
            ->orWhere('odometer', 'like', "%{$value}%")
            ->orWhere('deskripsi_keluhan', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('estimasi_harga', 'like', "%{$value}%")
            ->orWhere('tanggal_mulai_service', 'like', "%{$value}%")
            ->orWhere('tanggal_selesai_service', 'like', "%{$value}%")
            ->orWhere('keterangan', 'like', "%{$value}%");
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function montir()
    {
        return $this->belongsTo(Karyawan::class, 'montir_id');
    }

    public function spareparts()
    {
        return $this->hasMany(ServiceSparepart::class);
    }

    public function jasas()
    {
        return $this->hasMany(ServiceJasa::class);
    }

    public function statuses()
    {
        return $this->hasMany(StatusService::class);
    }

    public function serviceDetail()
    {
        return $this->hasOne(ServiceDetail::class);
    }

    // public function transaksi(){
    //     return $this->belongsTo(ServiceDetail::class);
    // }
}
