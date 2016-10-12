<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ["name"];
    /**
     * Relacionamento com Reservation
     * @return Reservation
     */
    public function reservation()
    {
        return $this->hasMany('App\Reservation');
    }
}
