<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusService extends Model
{
    use HasFactory;

    protected $table = 'status_services';

    protected $fillable = [
        'service_id',
        'kode_service',
        'status',
        'changed_at',
        'keterangan',
    ];

    protected $dates = [
        'changed_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Relasi ke Service
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
