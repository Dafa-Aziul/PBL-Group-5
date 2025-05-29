<?php

namespace App\Models;

use App\Models\Service;
use App\Models\Sparepart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSparepart extends Model
{
    use HasFactory;

    protected $table = 'service_spareparts';

    protected $guarded = []; // atau kamu bisa gunakan fillable jika ingin

    protected $fillable = [
        'service_id',       // foreign key ke tabel services
        'sparepart_id',     // foreign key ke tabel spareparts
        'jumlah',
        'harga',
        'subtotal',
    ];

    // Relasi ke service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relasi ke sparepart
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}
