<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Sparepart extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    protected $table = 'spareparts';
    protected $fillable = [
        'kode',
        'nama',
        'merk',
        'satuan',
        'stok',
        'harga',
        'model_kendaraan',
        'ket',
    ];
    public function scopeSearch($query, $value)
    {
        $query->where('kode', 'like', "%{$value}%")
            ->orWhere('nama', 'like', "%{$value}%")
            ->orWhere('merk', 'like', "%{$value}%")
            ->orWhere('satuan', 'like', "%{$value}%")
            ->orWhere('stok', 'like', "%{$value}%")
            ->orWhere('harga', 'like', "%{$value}%")
            ->orWhere('model_kendaraan', 'like', "%{$value}%")
            ->orWhere('ket', 'like', "%{$value}%");
    }
}
