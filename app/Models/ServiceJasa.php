<?php

namespace App\Models;

use App\Models\Jasa;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceJasa extends Model
{
    use HasFactory;

    protected $table = 'service_jasas';

    protected $guarded = [];

    protected $fillable = [
        'service_id',   // foreign key ke tabel services
        'jasa_id',      // foreign key ke tabel jasas
        'harga',
    ];

    // Relasi ke service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relasi ke jasa
    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    } 
}
