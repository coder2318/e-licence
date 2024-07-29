<?php

namespace App\Models\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'system',
        'request',
        'response',
        'error_code'
    ];

    protected $casts = [
        'request' => 'array',
        'response' => 'array',
    ];
}
