<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index');

Route::resource('fleets','FleetController', ['except' => 'create', 'show', 'edit']);

Route::resource('vehicles','VehicleController', ['except' => 'create', 'show', 'edit']);

Route::resource('routes','RouteController', ['except' => 'create', 'show', 'edit']);

Route::resource('trips','TripController', ['except' => 'create', 'show', 'edit']);

Route::post('/tickets/check','TicketController@checkTicket');
Route::get('/tickets/book', 'TicketController@bookTicket');
Route::resource('tickets','TicketController');

Auth::routes();