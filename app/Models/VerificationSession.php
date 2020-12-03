<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationSession extends Model
{
    use HasFactory;

    public $table = 'public.verification_sessions';

    protected $fillable = [
        'email', 'code', 'expired_at',
    ];
}
