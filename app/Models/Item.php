<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'sku',
        'image_url',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
