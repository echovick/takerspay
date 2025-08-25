<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_currency',
        'to_currency', 
        'rate',
        'source',
        'valid_until'
    ];

    protected $casts = [
        'rate' => 'decimal:8',
        'valid_until' => 'datetime'
    ];

    /**
     * Get current rate for a currency pair
     */
    public static function getCurrentRate(string $fromCurrency, string $toCurrency): ?float
    {
        $rate = self::where('from_currency', $fromCurrency)
            ->where('to_currency', $toCurrency)
            ->where('valid_until', '>', now())
            ->orderBy('created_at', 'desc')
            ->first();

        return $rate?->rate;
    }
}