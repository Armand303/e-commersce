<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'variants',
        'image',
    ];

    protected $casts = [
        'variants' => 'array',
    ];
}
