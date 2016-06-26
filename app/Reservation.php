<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        "title",
        "start",
        "end",
        "user_id",
        "room_id"
    ];
}
