@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Salas</div>
                    <div class="panel-body">
                      <a href="{{ URL::to('room/create') }}">Criar Sala</a>

                        @if (Session::has('message'))
                            <div class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif

                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rooms as $key => $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>

                                    <td align="right">

                                        {{ Form::open(array('url' => 'room/' . $value->id, 'class' => 'pull-right')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::submit('Excluir', array('class' => 'btn btn-warning')) }}
                                        {{ Form::close() }}

                                        <a class="btn btn-small btn-success" href="{{ URL::to('room/' . $value->id) }}">Visualizar</a>

                                        <a class="btn btn-small btn-info"
                                           href="{{ URL::to('room/' . $value->id . '/edit') }}">Editar</a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

