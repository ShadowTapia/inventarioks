<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    use HasFactory;

    /**
     * Relación uno es a muchos
     * Tabla Devices
     */
    public function devices()
    {
        return $this->hasMany(devices::class);
    }
}
