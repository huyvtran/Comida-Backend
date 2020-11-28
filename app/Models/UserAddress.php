<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    public $table = 'public.user_addresses';

    protected $fillable = [
        'user_id', 'type', 'address',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
