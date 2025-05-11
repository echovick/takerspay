<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'amount',
        'currency',
        'status',
        'fee',
        'balance_before',
        'balance_after',
        'transaction_reference',
        'transaction_type',
        'transaction_id',
        'transaction_response_object',
        'transaction_date',
        'transaction_description',
    ];

    protected $casts = [
        'transaction_response_object' => 'array',
        'transaction_date'            => 'datetime',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
