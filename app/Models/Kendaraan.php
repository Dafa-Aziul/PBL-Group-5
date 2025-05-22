<?php

namespace App\Models;

use App\Models\JenisKendaraan;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Kendaraan extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    protected $table = 'kendaraans';
    protected $fillable = [
        'pelanggan_id',
        'jenis_kendaraan_id',
        'no_polisi',
        'model_kendaraan',
        'odometer',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
    public function jenis_kendaraan(){
        return $this->belongsTo(JenisKendaraan::class, 'jenis_kendaraan_id');
    }    
}
