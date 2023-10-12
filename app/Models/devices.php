<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class devices extends Model
{
    use HasFactory;

    protected $fillable = [
        'numserie',
        'fechacompra',
        'comentarios',
        'estado',
        'product_id',
        'department_id',
    ];

    /**
     * Relación uno es a muchos inversa
     * Tabla Product
     */
    public function product()
    {
        return $this->belongsTo(product::class);
    }

    /**
     * Relación uno es a muchos inversa
     */
    public function department()
    {
        return $this->belongsTo(department::class);
    }

    /**
     * Relación uno es a muchos
     * Tabla Activity
     */
    public function activity()
    {
        return $this->hasMany(activity::class);
    }
}
