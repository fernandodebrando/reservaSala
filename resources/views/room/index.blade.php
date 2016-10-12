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
                                <td>Nome</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($rooms as $key => $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>

                                    <td align="right">

                                        {{ Form::open(array('url' => 'room/' . $value->id, 'class' => 'pull-right delete')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::submit('Excluir', array('class' => 'btn btn-warning')) }}
                                        {{ Form::close() }}

                                        <a class="btn btn-small btn-success" href="{{ URL::to('room/' . $value->id) }}">Visualizar</a>

                                        <a class="btn btn-small btn-info"
                                           href="{{ URL::to('room/' . $value->id . '/edit') }}">Editar</a>

                                    </td>
                                </tr>
                            @empty
                                <table>
                                <tr>
                                    <td>
                                        <div class="alert alert-info">Sem registros!</div>
                                    </td>
                                </tr>
                                </table>
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".delete").on("submit", function () {
            return confirm("Tem certeza que quer excluir este registro? O mesmo pode ter reservas vinculadas que também serão excluidas.");
        });
    </script>
@endsection

