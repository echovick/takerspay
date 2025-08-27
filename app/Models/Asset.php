<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    /** @use HasFactory<\Database\Factories\AssetFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'available_units',
        'naira_buy_rate',
        'naira_sell_rate',
        'is_active'
    ];
}
