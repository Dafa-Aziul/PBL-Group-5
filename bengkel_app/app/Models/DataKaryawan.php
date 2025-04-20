<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataKaryawan extends Model
{
    /** @use HasFactory<\Database\Factories\DataKaryawanFactory> */
    use HasFactory;
    protected $table = 'data_karyawan';
    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'id_user', 'email', 'nama', 'jabatan',
        'no_hp', 'alamat', 'tanggal_masuk', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
