<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    protected $table = 'pelanggans';
    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
        'keterangan',
    ];

    public function scopeSearch($query, $value)
    {
        $query->where('nama', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%")
            ->orWhere('no_hp', 'like', "%{$value}%")
            ->orWhere('alamat', 'like', "%{$value}%")
            ->orWhere('keterangan', 'like', "%{$value}%");
    }
    
    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class);
    }
}
