<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'renewed_at',
        'expired_at',
    ];

    protected $casts = [
        'renewed_at' => 'datetime',
        'expired_at' => 'datetime',
    ];
}
