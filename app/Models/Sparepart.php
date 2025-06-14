<?php

namespace App\Models;

use App\Models\Gudang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Sparepart extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    protected $guarded = [];
    protected $table = 'spareparts';
    protected $fillable = [
        'kode',
        'nama',
        'merk',
        'satuan',
        'stok',
        'harga',
        'tipe_kendaraan',
        'foto',
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
            ->orWhere('tipe_kendaraan', 'like', "%{$value}%")
            ->orWhere('ket', 'like', "%{$value}%");
    }

    public function gudangs()
{
    return $this->hasMany(Gudang::class);
}
}
