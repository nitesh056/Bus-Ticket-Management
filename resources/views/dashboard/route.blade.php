@extends('layouts.base')
@section('content')
    <h1 class="my-4">Routes</h1>
    
    <div class="card p-2">
        <form class="form-inline" id="addForm" action="/routes" method="POST">
            @csrf
            <input type="text" class="form-control mr-sm-2" placeholder="Starting Point" name="sPoint">

            <input type="text" class="form-control mr-sm-2" placeholder="Destination" name="dPoint">

            <input type="number" step=".01" class="form-control mr-sm-2" placeholder="Distance in km." name="distance">

            <button type="submit" class="btn btn-primary">Add</button>
		</form>
		
		<form class="form-inline mt-2" id="editForm" style="display: none;" action="" method="POST">
			@csrf
			<input name="_method" type="hidden" value="PUT">

            <input type="text" class="form-control mr-sm-2" id="startEdit" name="sPointEdit">

            <input type="text" class="form-control mr-sm-2" id="destinationEdit" name="dPointEdit">

            <input type="number" step=".01" class="form-control mr-sm-2" id="distanceEdit" name="distanceEdit" >
			
            <button type="submit" class="btn btn-primary">Edit</button>
		</form>
    </div>

    @if(count($routes) > 0)
		<table class="table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Route Name</th>
					<th>Distance</th>
					<th>Edit</th>
				</tr>
			</thead>
			<tbody>
				@foreach($routes as $route)
					<tr>
                        <td>{{$route->id}}</td>
                        <td>{{$route->starting_point}} - {{$route->destination_point}}</td>
                        <td>{{$route->distance}} km</td>
						<td>
							<button class="btn btn-primary" onclick="showForm(
                                {{$route->id}},
                                '{{$route->starting_point}}',
                                '{{$route->destination_point}}',
                                {{$route->distance}})">edit</button>
							<form action="/routes/{{$route->id}}" method="post" style="display: inline">
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
			function showForm(num, s, d, distance) {
				actionAttValue = "/routes/"+num;
				$('#editForm').attr("action", actionAttValue);
				$('#startEdit').attr("value", s);
				$('#destinationEdit').attr("value", d);
                $('#distanceEdit').attr("value", distance);
				$('#editForm').show(100);
			}
		</script>
	@else
		<div class="jumbotron"><h1>Routes not found. Add them from the form above.</h1></div>
	@endif
@endsection