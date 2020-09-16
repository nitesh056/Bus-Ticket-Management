<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;
use App\Route;
use App\Vehicle;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trips = Trip::all();
        $routes = Route::all();
        $vehicles = Vehicle::all();
        return view('dashboard.trip', compact('trips', 'routes', 'vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'routeName' => 'required',
            'date' => 'required',
            'vehicle' => 'required',
            'price' => 'required'
        ]);

        $trips = new Trip();
        $trips->route_id = $request->input('routeName');
        $trips->departure_date = $request->input('date');
        $trips->vehicle_id = $request->input('vehicle');
        $trips->price = $request->input('price');
        $no_of_seats = $trips->vehicle->fleet->Seat_Row * $trips->vehicle->fleet->Seat_Column;
        $trips->available_seats = $no_of_seats;
        $trips->allocated_seats = array_fill(0, $no_of_seats, 0);
        $trips->save();
        return redirect('/trips');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'routeNameEdit' => 'required',
            'dateEdit' => 'required',
            'vehicleEdit' => 'required',
            'priceEdit' => 'required'
        ]);

        $trips = Trip::find($id);
        $trips->route_id = $request->input('routeNameEdit');
        $trips->departure_date = $request->input('dateEdit');
        $trips->vehicle_id = $request->input('vehicleEdit');
        $trips->price = $request->input('priceEdit');
        $trips->save();
        return redirect('/trips');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trip = Trip::find($id);
        $trip->delete();
        return redirect('/trips');
    }
}
