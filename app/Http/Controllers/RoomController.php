<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;



class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('room.index', ['rooms' => Room::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (empty($request->get('name'))) {
            return Redirect::back()->withErrors('Nome é obrigatório.');
        } else {
            // store
            $room = new Room;
            $room->name = $request->get('name');
            $room->save();

            // redirect
            Session::flash('message', 'Sala criada com sucesso!');
            return Redirect::to('room');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('room.show', ['room' => Room::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('room.edit', ['room' => Room::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (empty($request->get('name'))) {
            return Redirect::back()->withErrors('Nome é obrigatório.');
        } else {
            // store
            $room = Room::find($id);
            $room->name = $request->get('name');
            $room->save();

            // redirect
            Session::flash('message', 'Sala editada com sucesso!');
            return Redirect::to('room');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        $room = Room::find($id);
        $room->delete();

        // redirect
        Session::flash('message', 'Sala excluida com sucesso!');
        return Redirect::to('room');
    }
}
