@extends('layouts.app')

@section('content')
    <link href="{{ asset('/assets/css/fullcalendar.css')}}" rel='stylesheet'/>
    <link href="{{ asset('/assets/css/fullcalendar.print.css')}}" rel='stylesheet' media='print'/>
    <link href="{{ asset('/assets/css/home.css')}}" rel='stylesheet'/>
    <script src="{{ asset('/assets/js/moment.min.js')}}"></script>
    <script src="{{ asset('/assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('/assets/js/fullcalendar.min.js')}}"></script>
    <script src="{{ asset('/assets/js/home.js')}}"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Agenda</div>
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                            @forelse($rooms as $key => $room)
                                <li class="{{$key == 0 ? 'active' : ''}}" data-idroom="{{$room['id']}}"><a
                                            data-toggle="tab" href="#room_{{$room['id']}}"
                                            onclick="renderCalendar({{$room['id']}})">{{$room['name']}}</a></li>
                            @empty
                                <li>
                                    <div class="alert alert-info">Sem registros! Primeiramente deve existir uma sala cadastrada.</div>
                                </li>
                            @endforelse
                        </ul>
                        <div class="tab-content"><br>
                            @foreach($rooms as $key => $room)
                                <div id="room_{{$room['id']}}" class="tab-pane fade in {{$key == 0 ? 'active' : ''}}">
                                    <div id='wrap_{{$room['id']}}' class="wrap">
                                        <div id='external-events_{{$room['id']}}' class="external-events">
                                            <h4>Arraste para a agenda a nova reserva</h4>
                                            <div class='fc-event' data-name="{{ Auth::user()->name }}">Nova Reserva
                                            </div>
                                            <h4>Arraste para a lixeira para excluir a reserva</h4>
                                            <p>
                                                <img src="assets/img/trashcan.png" id="trash_{{$room['id']}}" alt=""
                                                     class="trash">
                                            </p>
                                        </div>

                                        <div id='calendar_room_{{$room['id']}}' class="calendar"></div>

                                        <div style='clear:both'></div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
