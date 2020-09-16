<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fleet;
use App\Vehicle;
use App\Trip;

class FleetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fleetTypes = Fleet::all();
        return view('dashboard.fleet', compact('fleetTypes'));
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
            'fleet' => 'required',
            'seat_row' => 'required',
            'seat_column' => 'required'
        ]);
        $fleetTypes = new Fleet();
        $fleetTypes->fleet_type = $request->input('fleet');
        $fleetTypes->Seat_Row = $request->input('seat_row');
        $fleetTypes->Seat_Column = $request->input('seat_column');
        $fleetTypes->save();
        return redirect('/fleets');
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
            'fleetEdit' => 'required',
            'rowEdit' => 'required',
            'colEdit' => 'required'
        ]);
        $fleetTypes = Fleet::find($id);
        $fleetTypes->fleet_type = $request->input('fleetEdit');
        $fleetTypes->Seat_Row = $request->input('rowEdit');
        $fleetTypes->Seat_Column = $request->input('colEdit');
        $fleetTypes->save();
        return redirect('/fleets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fleetTypes = Fleet::find($id);
        $vehicles = Vehicle::where('fleet_id', $id)->get();
        foreach($vehicles as $vehicle){
            $trips = Trip::where('vehicle_id', $vehicle->id)->get();
            foreach ($trips as $trip) {
                $trip->delete();
            }
            $vehicle->delete();
        }
        $fleetTypes->delete();
        return redirect('/fleets');
    }
}
