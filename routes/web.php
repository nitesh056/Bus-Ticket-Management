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

Route::resource('vehicles','VehicleController');

Route::resource('routes','RouteController');

Route::resource('trips','TripController');

Route::resource('tickets','TicketController');

Auth::routes();