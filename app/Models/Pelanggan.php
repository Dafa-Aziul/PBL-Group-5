<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    public function jenisKendaraan()
    {
        return $this->belongsTo(JenisKendaraan::class);
    }
}
