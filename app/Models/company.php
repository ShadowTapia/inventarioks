<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'url',
        'phone',
        'email',
        'contact'
    ];

    /**
     * Relación uno a muchos
     */
    public function products()
    {
        return $this->hasMany(products::class, 'company_id', 'id');
    }
}
