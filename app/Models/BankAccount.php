<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    /** @use HasFactory<\Database\Factories\BankAccountFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'currency',
        'name',
        'recipient_code',
        'type',
        'account_number',
        'account_name',
        'bank_code',
        'bank_name',
        'is_default',
        'data_response_object',
    ];

    protected $casts = [
        'data_response_object' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
