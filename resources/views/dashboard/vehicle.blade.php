@extends('layouts.base')
@section('content')
    <h1 class="my-4">Vehicles</h1>
    @if(count($fleetTypes) > 0)
        <div class="card p-2">
            <form class="form-inline" id="addForm" action="/vehicles" method="POST">
                @csrf
                <input type="text" class="form-control mr-sm-2" placeholder="Vehicle Name" name="vehicle">

                <select class="form-control mr-sm-2" name="fleet_type">
                    @foreach($fleetTypes as $fleetType)
                        <option value="{{$fleetType->id}}">{{$fleetType->fleet_type}}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-primary">Add</button>
            </form>
            
            <form class="form-inline mt-2" id="editForm" style="display: none;" action="" method="POST">
                @csrf
                <input name="_method" type="hidden" value="PUT">

                <input type="text" class="form-control mr-sm-2" id="vehicleEdit" name="vehicleEdit">

                <select class="form-control mr-sm-2" id="fleetTypeEdit" name="fleet_type">
                    @foreach($fleetTypes as $fleetType)
                        <option value="{{$fleetType->id}}">{{$fleetType->fleet_type}}</option>
                    @endforeach
                </select>
                
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>

        @if(count($vehicles) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Vehicles</th>
                        <th>Status</th>
                        <th>Fleet Type</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                        <tr>
                            <td>{{$vehicle->id}}</td>
                            <td>{{$vehicle->vehicle}}</td>
                            <td>{{$vehicle->status}}</td>
                            <td>{{$vehicle->fleet->fleet_type}}</td>
                            <td>
                                <button class="btn btn-primary" onclick="showForm({{$vehicle->id}}, '{{$vehicle->vehicle}}', {{$vehicle->fleet_id}})">edit</button>
                                <form action="/vehicles/{{$vehicle->id}}" method="post" style="display: inline">
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
                function showForm(id, vehicle, fleat_id) {
                	actionAttValue = "/vehicles/"+id;
                	$('#editForm').attr("action", actionAttValue);
                	$('#vehicleEdit').attr("value", vehicle);
                    $('#fleetTypeEdit>option[value="2"]').attr('selected', 'selected');
                	$('#editForm>button').text("Edit " + vehicle);
                	$('#editForm').show(100);
                }
            </script>
        @else
            <div class="jumbotron"><h1>Vehicle not found. Add them from the form above.</h1></div>
        @endif
    @else
        <div class="jumbotron"><h1>Please add some Fleet types before adding Vehicle.</h1></div>
    @endif
@endsection