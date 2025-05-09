<?php

namespace App\Models;

use App\Models\JenisKendaraan;
use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    public function jenisKendaraan()
    {
        return $this->belongsTo(JenisKendaraan::class);
    }
}
