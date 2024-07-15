<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'guard_name',
        'orden'
    ];
}
