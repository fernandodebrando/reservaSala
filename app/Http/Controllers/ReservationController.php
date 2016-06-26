<?php

namespace App\Http\Controllers;

use App\Reservation;
use App\Room;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;

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
        $room = $request->input('room');

       /* $startdate = $_POST['startdate'].'+'.$_POST['zone'];
        $title = $_POST['title'];
        $insert = mysqli_query($con,"INSERT INTO calendar(`title`, `startdate`, `enddate`, `allDay`) VALUES('$title','$startdate','$startdate','false')");
        $lastid = mysqli_insert_id($con);
        echo json_encode(array('status'=>'success','eventid'=>$lastid));*/

        try{


            $response = ['status'=>'success','eventid'=>1];

        }catch (Exception $e){
            $response = ['status'=>'error'];
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
