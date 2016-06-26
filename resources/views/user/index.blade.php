@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Usuários</div>
                    <div class="panel-body">
                      <a href="{{ URL::to('user/create') }}">Criar Usuários</a>

                        @if (Session::has('message'))
                            <div class="alert alert-info">{{ Session::get('message') }}</div>
                        @endif

                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nome</td>
                                <td>Email</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $key => $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->email }}</td>

                                    <td align="right">

                                        {{ Form::open(array('url' => 'user/' . $value->id, 'class' => 'pull-right')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        {{ Form::submit('Excluir', array('class' => 'btn btn-warning')) }}
                                        {{ Form::close() }}

                                        <a class="btn btn-small btn-success" href="{{ URL::to('user/' . $value->id) }}">Visualizar</a>

                                        <a class="btn btn-small btn-info"
                                           href="{{ URL::to('user/' . $value->id . '/edit') }}">Editar</a>

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

