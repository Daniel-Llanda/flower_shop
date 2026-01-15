<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosItem extends Model
{
    protected $fillable = [
        'item_name',
        'item_price',
        'item_type',
    ];
}
