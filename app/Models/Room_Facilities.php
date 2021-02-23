<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_Facilities extends Model
{
    use HasFactory;
    protected $table = 'room_facilities';
    protected $fillable = ['room_id', 'facilitie_id', 'is_active'];
}
