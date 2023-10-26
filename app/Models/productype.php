<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productype extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relación uno es a muchos
     * Tabla Product
     */
    public function products()
    {
        return $this->hasMany(products::class, 'productype_id', 'id');
    }
}
