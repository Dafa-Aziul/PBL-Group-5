<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPelanggan extends Model
{
    /** @use HasFactory<\Database\Factories\DataPelangganFactory> */
    use HasFactory;
    protected $table = 'data_pelanggan';
    protected $primaryKey = 'id_pegawai';

    protected $fillable = [
        'id_user', 'email', 'nama', 'jabatan',
        'no_hp', 'alamat', 'tanggal_masuk', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
