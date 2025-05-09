<?php

namespace App\Models;

use App\Models\Jasa;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Model;

class JenisKendaraan extends Model
{
    public function jasas()
    {
        return $this->hasMany(Jasa::class);
    }

    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class);
    }
}
