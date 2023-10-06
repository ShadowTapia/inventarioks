<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productype extends Model
{
    use HasFactory;

    /**
     * Relación uno es a muchos
     * Tabla Product
     */
    public function product()
    {
        return $this->hasMany(product::class);
    }
}
