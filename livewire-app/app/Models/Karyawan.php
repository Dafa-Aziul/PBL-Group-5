<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    public function kontens()
    {
        return $this->hasMany(Konten::class, 'penulis_id');
    }
}
