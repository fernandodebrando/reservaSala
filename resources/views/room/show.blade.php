@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Visualização de Sala</div>
                    <div class="panel-body">
                        <a href="{{ URL::to('room') }}">Lista de Salas</a>

                        <h1>Visualização</h1>

                        <div class="jumbotron text-left">
                            <p>
                                <strong>Nome:</strong> {{ $room->name }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

