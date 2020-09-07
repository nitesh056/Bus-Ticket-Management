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

Route::resource('fleet','FleetController', ['except' => 'create', 'show']);

Route::resource('vehicle','VehicleController');

Route::resource('route','RouteController');

Route::resource('trip','TripController');

Route::resource('ticket','TicketController');

Auth::routes();