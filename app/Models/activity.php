<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    use HasFactory;

    /**
     * Relación uno es a muchos inversa
     * Tabla Devices
     */
    public function devices()
    {
        return $this->belongsTo(devices::class);
    }
}
