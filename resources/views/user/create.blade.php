@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Criar Usuário</div>
                    <div class="panel-body">
                       <a href="{{ URL::to('user') }}">Listagem de Usuários</a>

                        {{ Html::ul($errors->all()) }}

                        {{ Form::open(array('url' => 'user')) }}

                        <div class="form-group">
                            {{ Form::label('name', 'Nome') }}
                            {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('email', 'Email') }}
                            {{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
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

