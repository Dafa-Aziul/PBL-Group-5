<?php

namespace App\Models;

use App\Models\Sparepart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Gudang extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    protected $table = 'gudangs';
    protected $fillable = [
        'sparepart_id', 'aktivitas', 'jumlah', 'keterangan'
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'sparepart_id');
    }

    protected static function booted()
    {
        static::created(function ($gudang) {
            $sparepart = $gudang->sparepart;

            if ($gudang->aktivitas === 'masuk') {
                $sparepart->stok += $gudang->jumlah;
            } elseif ($gudang->aktivitas === 'keluar') {
                $sparepart->stok -= $gudang->jumlah;
            }

            $sparepart->save();
        });
    }




}
