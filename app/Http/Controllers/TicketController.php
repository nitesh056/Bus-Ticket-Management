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
                $trip['row'] = $trip->vehicle->fleet->Seat_Row;
                $trip['column'] = $trip->vehicle->fleet->Seat_Column;
                array_push($listTickets, $trip);
            }
        }
        $data = [
            'listTickets' => $listTickets
        ];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $trip = Trip::find($request->input('trip'));
        $new_allocated_seat = array_sum($request->input('new_allocated_seats'));
        $this->validate($request, [
            'trip' => 'required',
        ]);

        $ticket = new Ticket();
        $ticket->trip_id = $request->input('trip');
        $ticket->user_id = auth()->user()->id;
        $ticket->no_of_passenger = $new_allocated_seat;
        $ticket->amount = $trip->price * $new_allocated_seat;
        $ticket->allocated_seats = $request->input('new_allocated_seats');
        
        $trip->allocated_seats = $request->input('all_allocated_seats');
        $trip->available_seats = $trip->available_seats - $new_allocated_seat;
        $ticket->save();
        $trip->save();
        return redirect('/tickets');
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
