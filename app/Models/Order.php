<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference',
        'type',
        'asset_id',
        'asset',
        'asset_value',
        'dollar_price',
        'naira_price',
        'transaction_status',
        'file_url',
        'wallet_id',
        'confirmed_at',
        'fulfilled_at',
        'order_step'
    ];

    protected $dates = [
        'confirmed_at',
        'fulfilled_at',
    ];

    protected $cast = [
        'chat' => 'json'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function assetInfo()
    {
        return $this->belongsTo(Asset::class);
    }

}
