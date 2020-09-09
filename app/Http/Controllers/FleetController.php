<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fleet;

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
     * $table->bigIncrements('id');
*            // $table->string('fleet_type');
 *           // $table->integer('total_seat');
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'fleet' => 'required',
            'seat' => 'required'
        ]);
        $fleetTypes = new Fleet();
        $fleetTypes->fleet_type = $request->input('fleet');
        $fleetTypes->total_seat = $request->input('seat');
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
            'seatEdit' => 'required'
        ]);
        $fleetTypes = Fleet::find($id);
        $fleetTypes->fleet_type = $request->input('fleetEdit');
        $fleetTypes->total_seat = $request->input('seatEdit');
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
        $fleetTypes->delete();
        return redirect('/fleets');
    }
}
