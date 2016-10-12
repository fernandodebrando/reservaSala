@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Usuário</div>
                    <div class="panel-body">
                        <a href="{{ URL::to('user') }}">Listagem de  Usuários</a>

                        <h3>Editar {{ $user->name }}</h3>

                        {{ Html::ul($errors->all()) }}

                        {{ Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT')) }}

                        <div class="form-group">
                            {{ Form::label('name', 'Nome') }}
                            {{ Form::text('name', null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('email', 'Email') }}
                            {{ Form::text('email', null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('password', 'Senha') }}
                            {{ Form::password('password', array('class' => 'form-control')) }}
                        </div>

                        {{ Form::submit('Salvar', array('class' => 'btn btn-primary')) }}

                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

