<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'modelo',
        'users_id',
        'productype_id',
        'supplier_id', //Proveedor
        'company_id',
    ];


    /**
     * Relación uno es a muchos inversa
     */
    public function user()
    {
        return $this->belongsTo(products::class, 'id', 'users_id');
    }

    /**
     * Relación uno es a muchos inversa
     */
    public function suppliers()
    {
        return $this->belongsTo(supplier::class, 'supplier_id');
    }

    /**
     * Relación uno es a mucho inversa
     */
    public function productypes()
    {
        return $this->belongsTo(productype::class, 'productype_id');
    }

    /**
     * Relación uno es a muchos inversa
     */
    public function companies()
    {
        return $this->belongsTo(company::class, 'company_id');
    }

    /**
     *
     * Relación uno a uno polimorfica
     */
    public function image()
    {
        return $this->morphOne(image::class, 'imageable');
    }
}
