<?php

namespace App\Http\Controllers;


use App\Reservation;
use App\Room;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Room::with('reservation')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = [];
        $title = $request->input('title');
        $startdate = $request->input('startdate').'+'.$request->input('zone');
        $enddate = $request->input('enddate').'+'.$request->input('zone');
        $idRoom = $request->input('idroom');
        $idUser = Auth::user()->id;
        try{
            $reservation = new Reservation();
            if(!$reservation->validadeReservation($idUser, $startdate, $enddate)){
                throw new Exception('Não é possível reservar mais de uma sala no mesmo período.');
            }

            $reservation = Reservation::create(['title' => $title, 'start' => $startdate, 'end' => $enddate, 'room_id' => $idRoom, 'user_id' => $idUser]);
            $response = ['status'=>'success','reservationId'=> $reservation->id];

        }catch (Exception $e){
            $response = ['status'=>'error', 'msg' => $e->getMessage()];
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = [];
        $title = $request->input('title');
        $startdate = $request->input('startdate').'+'.$request->input('zone');
        $enddate = $request->input('enddate').'+'.$request->input('zone');
        $idUser = Auth::user()->id;
        try{


            if(!Reservation::where('user_id', $idUser)->where('id', $id)->count()){
                throw new Exception('Para editar uma reserva você deve ser o criador da mesma.');
            }else{
                Reservation::where('id', $id)->update(['title' => $title, 'start' => $startdate, 'end' => $enddate]);
            }

            $response = ['status'=>'success'];

        }catch (Exception $e){
            $response = ['status'=>'error', 'msg' => $e->getMessage()];
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = [];
        try{

            if(!Reservation::where('user_id', Auth::user()->id)->where('id', $id)->count()){
                throw new Exception('Para remover uma reserva você deve ser o criador da mesma.');
            }else{
                Reservation::where('id', $id)->delete();
            }

            $response = ['status'=>'success'];

        }catch (Exception $e){
            $response = ['status'=>'error', 'msg' => $e->getMessage()];
        }
        return $response;
    }

    /**
     * Display the specified resource by Room.
     *
     * @param  int  $idRoom
     * @return \Illuminate\Http\Response
     */
    public function byRoom($idRoom){
        
        return Reservation::where('room_id', $idRoom)->get();
    }
}
