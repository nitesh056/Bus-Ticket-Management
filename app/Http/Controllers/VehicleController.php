<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use App\Fleet;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        $fleetTypes = Fleet::all();
        return view('dashboard.vehicle', compact('fleetTypes', 'vehicles'));
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
            'vehicle' => 'required',
            'fleet_type' => 'required'
        ]);

        $vehicle = new Vehicle();
        $vehicle->vehicle = $request->input('vehicle');
        $vehicle->status = 'available';
        $vehicle->fleet_id = $request->input('fleet_type');
        $vehicle->save();
        return redirect('/vehicles');
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
            'vehicleEdit' => 'required',
            'fleet_type' => 'required'
        ]);

        $vehicle = Vehicle::find($id);
        $vehicle->vehicle = $request->input('vehicleEdit');
        $vehicle->fleet_id = $request->input('fleet_type');
        $vehicle->save();
        return redirect('/vehicles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->delete();
        return redirect('/vehicles');
    }
}
