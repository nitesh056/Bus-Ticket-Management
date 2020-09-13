@extends('layouts.base')
@section('content')
    <h1 class="my-4">Tickets</h1>
    @if(count($tickets) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Vehicle</th>
                    <th>Route</th>
                    <th>User</th>
                    <th>Number of Passenger</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{$ticket->id}}</td>
                        <td>{{$ticket->trip->vehicle->vehicle}}</td>
                        <td>{{$ticket->trip->route->starting_point}} - {{$ticket->trip->route->destination_point}}</td>
                        <td>{{$ticket->user->name}}</td>
                        <td>{{$ticket->no_of_passenger}}</td>
                        <td>{{$ticket->amount}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script defer>
            
        </script>
    @else
        <div class="jumbotron"><h1>Tickets not found.</h1></div>
    @endif
@endsection
