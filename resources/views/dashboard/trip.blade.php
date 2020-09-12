@extends('layouts.base')
@section('content')
    <h1 class="my-4">Trips</h1>
    @if(count($routes) > 0 && count($vehicles) > 0)
        <div class="card p-2">
            <form class="form-inline" id="addForm" action="/trips" method="POST">
                @csrf
                <select class="form-control mr-sm-2" name="routeName">
                    @foreach($routes as $route)
                        <option value="{{$route->id}}">{{$route->starting_point}} - {{$route->destination_point}}</option>
                    @endforeach
                </select>

                <input type="date" class="form-control mr-sm-2" name="date">

                <select class="form-control mr-sm-2" name="vehicle">
                    @foreach($vehicles as $vehicle)
                        <option value="{{$vehicle->id}}">{{$vehicle->vehicle}}</option>
                    @endforeach
                </select>

                <input type="number" step=".01" class="form-control mr-sm-2" placeholder="Price per person" name="price">

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
            
            <form class="form-inline mt-2" id="editForm" style="display: none;" action="" method="POST">
                @csrf
                <input name="_method" type="hidden" value="PUT">
                <select class="form-control mr-sm-2" id="routeNameEdit" name="routeNameEdit">
                    @foreach($routes as $route)
                        <option value="{{$route->id}}">{{$route->starting_point}} - {{$route->destination_point}}</option>
                    @endforeach
                </select>

                <input type="date" class="form-control mr-sm-2" name="dateEdit">

                <select class="form-control mr-sm-2" id="vehicleEdit" name="vehicleEdit">
                    @foreach($vehicles as $vehicle)
                        <option value="{{$vehicle->id}}">{{$vehicle->vehicle}}</option>
                    @endforeach
                </select>

                <input type="number" step=".01" class="form-control mr-sm-2" id="priceEdit" name="priceEdit">
                
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>

        @if(count($trips) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Route</th>
                        <th>Vehicle</th>
                        <th>Departure Date</th>
                        <th>Price</th>
                        <th>Availabe seats</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trips as $trip)
                        <tr>
                            <td>{{$trip->id}}</td>
                            <td>{{$trip->route->starting_point}} - {{$trip->route->destination_point}}</td>
                            <td>{{$trip->vehicle->vehicle}}</td>
                            <td>{{$trip->departure_date}}</td>
                            <td>{{$trip->price}}</td>
                            <td>{{$trip->available_seats}}</td>
                            <td>
                                <button class="btn btn-primary" onclick="showForm({{$trip->id}}, {{$trip->route_id}}, {{$trip->vehicle_id}}, {{$trip->price}})">edit</button>
                                <form action="/trips/{{$trip->id}}" method="post" style="display: inline">
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input class="btn btn-danger" type="submit" value="Delete">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
            <script defer>
                function showForm(id, route_id, vehicle_id, price) {
                	actionAttValue = "/trips/"+id;
                	$('#editForm').attr("action", actionAttValue);
                    $('#routeNameEdit>option[value="'+route_id+'"]').attr('selected', 'selected');
                    $('#vehicleEdit>option[value="'+vehicle_id+'"]').attr('selected', 'selected');
                    $('#priceEdit').attr("value", price);
                	$('#editForm>button').text("Edit");
                	$('#editForm').show(100);
                }
            </script>
        @else
            <div class="jumbotron"><h1>Trips not found. Add them from the form above.</h1></div>
        @endif
    @else
        <div class="jumbotron"><h1>Please add some Vehicles and Routes before adding Trip.</h1></div>
    @endif
@endsection