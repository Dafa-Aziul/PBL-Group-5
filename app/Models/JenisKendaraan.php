<?php

namespace App\Models;

use App\Models\Jasa;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class JenisKendaraan extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    protected $table = 'jenis_kendaraans';
    protected $fillable = [
        'nama_jenis',
        'tipe_kendaraan',
        'deskripsi',
    ];


    public function jasas()
    {
        return $this->hasMany(Jasa::class);
    }

    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class);
    }
    public function scopeSearch($query, $value)
    { 
        $query->where('nama_jenis', 'like', "%{$value}%")
            ->orWhere('tipe_kendaraan', 'like',"%{$value}%")
            ->orWhere('deskripsi', 'like', "%{$value}%");
    }

}
