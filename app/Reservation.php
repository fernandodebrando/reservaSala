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


    /**
     * @description Um usuário não pode reservar mais de 1 sala no mesmo período
     * @param $userId
     * @param $room
     * @param $start
     * @param $end
     * @return bool
     */
    public function validadeReservation($userId, $start, $end, $reservationId = null)
    {

        if ($reservationId)
            $reservation = $this->where('id', '<>', $reservationId)->where('user_id', $userId)->where('start', $start)->where('end', $end)->count();
        else
            $reservation = $this->where('user_id', $userId)->where('start', $start)->where('end', $end)->count();

        if ($reservation) {
            return false;
        }

        return true;
    }
}
