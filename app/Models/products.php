<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(products::class, 'id', 'users_id');
    }

    /**
     * Relación uno es a muchos inversa
     */
    public function suppliers()
    {
        return $this->belongsTo(supplier::class, 'id', 'supplier_id');
    }
}
