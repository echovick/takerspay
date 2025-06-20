<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    /** @use HasFactory<\Database\Factories\WalletFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asset_id',
        'type',
        'crypto_wallet_number',
        'account_number',
        'bank_name',
        'account_name',
        'status',
        'balance',
        'bank_id',
        'bank_slug',
        'currency',
        'assigned_at',
        'customer_id',
        'account_creation_response_object',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
