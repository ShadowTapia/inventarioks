<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'contact',
        'email',
    ];

    /**
     * Relación uno a muchos
     */
    public function products()
    {
        return $this->hasMany(products::class, 'supplier_id', 'id');
    }
}
