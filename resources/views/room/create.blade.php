@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Criar Sala</div>
                    <div class="panel-body">
                       <a href="{{ URL::to('room') }}">Listagem de  Salas</a>

                        {{ Html::ul($errors->all()) }}

                        {{ Form::open(array('url' => 'room')) }}

                        <div class="form-group">
                            {{ Form::label('name', 'Nome') }}
                            {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
                        </div>

                        {{ Form::submit('Salvar', array('class' => 'btn btn-primary')) }}

                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

