<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMetaData extends Model
{
    /** @use HasFactory<\Database\Factories\UserMetaDataFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tag',
        'first_name',
        'last_name',
        'profile_image',
        'email_verified_at',
    ];

    protected $dates = [
        'email_verified_at',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}