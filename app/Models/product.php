<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'modelo',
        'productype_id',
        'supplier_id',
        'company_id'
    ];

    /**
     * Relación uno es a muchos inversa
     * Tabla User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación uno es a muchos inversa
     * Tabla Company
     */
    public function company()
    {
        return $this->belongsTo(company::class);
    }

    /**
     * Relación uno es a muchos inversa
     * Tabla Supplier
     */
    public function supplier()
    {
        return $this->belongsTo(supplier::class);
    }

    /**
     * Relación uno es a muchos inversa
     * Tabla Peoductype
     */
    public function productype()
    {
        return $this->belongsTo(productype::class);
    }

    /**
     * Relación uno es a muchos
     * Tabla Devices
     */
    public function devices()
    {
        return $this->hasMany(devices::class);
    }
}
