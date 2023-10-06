<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;

    /**
     * Relación uno a muchos
     */
    public function product()
    {
        return $this->hasMany(product::class);
    }
}
