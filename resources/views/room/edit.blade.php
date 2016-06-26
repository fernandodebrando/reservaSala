@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Sala</div>
                    <div class="panel-body">
                        <a href="{{ URL::to('room') }}">Listagem de  Salas</a>

                        <h3>Editar {{ $room->name }}</h3>

                        {{ Html::ul($errors->all()) }}

                        {{ Form::model($room, array('route' => array('room.update', $room->id), 'method' => 'PUT')) }}

                        <div class="form-group">
                            {{ Form::label('name', 'Nome') }}
                            {{ Form::text('name', null, array('class' => 'form-control')) }}
                        </div>

                        {{ Form::submit('Salvar', array('class' => 'btn btn-primary')) }}

                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

