@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Visialização de Usuário</div>
                    <div class="panel-body">
                        <a href="{{ URL::to('user') }}">Listagem de Usuários</a>

                        <h1>Visualização</h1>

                        <div class="jumbotron text-left">
                            <p>
                                <strong>Nome:</strong> {{ $user->name }}
                            </p>
                            <p>
                                <strong>Email:</strong> {{ $user->email }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

