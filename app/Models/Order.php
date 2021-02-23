<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'user_id',
        'guests',
        'check_in',
        'check_out',
        'total_days',
        'message',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
