<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Validator;



class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        );

        $messages = array(
            'name.required' => 'Nome do usuário é o obrigatório',
            'email.required' => 'E-mail do usuário é o obrigatório',
            'email.email' => 'Email inválido',
            'email.unique' => 'Email já registrado',
            'password.required' => 'Nova senha é o obrigatório',
            'password.min' => 'Nova senha deve conter no mínimo 6 caracteres',
        );
        $validator = Validator::make($data = $request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            // store
            $user = new User;
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));
            $user->save();

            // redirect
            Session::flash('message', 'Usuário criado com sucesso!');
            return Redirect::to('user');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('user.show', ['user' => User::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('user.edit', ['user' => User::find($id)]);
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
        $user = User::find($id);
        $rules = array(
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        );

        if($request->get('email') != $user->email){
            $rules['email'] = 'required|email|unique:users';
        }

        $messages = array(
            'name.required' => 'Nome do usuário é o obrigatório',
            'email.required' => 'E-mail do usuário é o obrigatório',
            'email.email' => 'Email inválido',
            'email.unique' => 'Email já registrado',
            'password.required' => 'Nova senha é o obrigatório',
            'password.min' => 'Nova senha deve conter no mínimo 6 caracteres',
        );
        $validator = Validator::make($data = $request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            // update
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = bcrypt($request->get('password'));
            $user->save();


            // redirect
            Session::flash('message', 'Usuário alterado com sucesso!');
            return Redirect::to('user');
        
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        $user = User::find($id);
        $user->delete();

        // redirect
        Session::flash('message', 'Usuário excluido com sucesso!');
        return Redirect::to('user');
    }
}
