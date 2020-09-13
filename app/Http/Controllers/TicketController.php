<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Route;
use App\Fleet;
use App\Trip;
use App\Vehicle;
use App\Ticket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();
        return view('dashboard.ticket', compact('tickets'));
    }

    /**
     * Show the form for booking Ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function bookTicket()
    {
        $routes = Route::all();
        $fleets = Fleet::all();
        return view('dashboard.bookTicket', compact('routes', 'fleets'));
    }

    /**
     * Checks for the trips.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkTicket(Request $request)
    {
        $booking = $request->input('bookingDate');
        $route = +$request->input('route');
        $fleet = +$request->input('fleet');
        $trips = Trip::where([
            ['departure_date', '=', $booking],
            ['route_id', '=', $route]
        ])->get();
        $listTickets = [];
        foreach ($trips as $trip) {
            if ($trip->vehicle->fleet_id == $fleet && $trip->available_seats>0) {
                array_push($listTickets, $trip);
            }
        }
        return response()->json(array('messages'=> $listTickets), 200);
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
            'trip' => 'required',
            'no_of_tickets' => 'required'
        ]);

        $ticket = new Ticket();
        $ticket->trip_id = $request->input('trip');
        $ticket->user_id = auth()->user()->id;
        $ticket->no_of_passenger = $request->input('no_of_tickets');
        $trip = Trip::find($ticket->trip_id);
        $ticket->amount = $trip->price * $request->input('no_of_tickets');
        $trip->available_seats = $trip->available_seats - $ticket->no_of_passenger;
        $ticket->save();
        $trip->save();
        return redirect('/tickets');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
