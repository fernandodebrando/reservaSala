<?php

Route::auth();

Route::get('/', 'HomeController@index');

Route::resource('reservation', 'ReservationController');

Route::get('/reservation/byRoom/{idRoom}', 'ReservationController@byRoom');

Route::resource('user', 'UserController');

Route::resource('room', 'RoomController');

