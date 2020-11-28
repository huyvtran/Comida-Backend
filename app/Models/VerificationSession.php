<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationSession extends Model
{
    use HasFactory;

    public $table = 'public.verification_sessions';

    protected $fillable = [
        'user_id', 'code', 'expired_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
