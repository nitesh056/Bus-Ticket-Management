<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Route;
use App\Trip;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Route::all();
        return view('dashboard.route', compact('routes'));
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
            'sPoint' => 'required',
            'dPoint' => 'required',
            'distance' => 'required'
        ]);
        $route = new Route();
        $route->starting_point = $request->input('sPoint');
        $route->destination_point = $request->input('dPoint');
        $route->distance = $request->input('distance');
        $route->save();
        return redirect('/routes');
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
            'sPointEdit' => 'required',
            'dPointEdit' => 'required',
            'distanceEdit' => 'required'
        ]);
        $route = Route::find($id);
        $route->starting_point = $request->input('sPointEdit');
        $route->destination_point = $request->input('dPointEdit');
        $route->distance = $request->input('distanceEdit');
        $route->save();
        return redirect('/routes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $route = Route::find($id);
        $trips = Trip::where('route_id', $route->id)->get();
        foreach ($trips as $trip) {
            $trip->delete();
        }
        $route->delete();
        return redirect('/routes');
    }
}
