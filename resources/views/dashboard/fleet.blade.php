@extends('layouts.base')
@section('content')
    <h1 class="my-4">Fleet Type</h1>
    
    <div class="card p-2">
        <form class="form-inline" id="addForm" action="/fleets" method="POST">
            @csrf
            <input type="text" class="form-control mr-sm-2" placeholder="Fleet Type" name="fleet">

			<input type="number" class="form-control mr-sm-2" placeholder="Number of row of seat" name="seat_row">
			
			<input type="number" class="form-control mr-sm-2" placeholder="Number of column of seat" name="seat_column">

            <button type="submit" class="btn btn-primary">Add</button>
		</form>
		
		<form class="form-inline mt-2" id="editForm" style="display: none;" action="" method="POST">
			@csrf
			<input name="_method" type="hidden" value="PUT">

			<input type="text" class="form-control mr-sm-2" id="fleetEdit" name="fleetEdit">

			<input type="number" class="form-control mr-sm-2" id="rowEdit" name="rowEdit">
			
			<input type="number" class="form-control mr-sm-2" id="colEdit" name="colEdit">
			
            <button type="submit" class="btn btn-primary">Edit</button>
		</form>
    </div>

    @if(count($fleetTypes) > 0)
		<table class="table">
			<thead>
				<tr>
					<th>Id</th>
					<th>Fleet Type</th>
					<th>Row of seat</th>
					<th>Column of seat</th>
					<th>Edit</th>
				</tr>
			</thead>
			<tbody>
				@foreach($fleetTypes as $fleetType)
					<tr>
						<td>{{$fleetType->id}}</td>
                        <td>{{$fleetType->fleet_type}}</td>
						<td>{{$fleetType->Seat_Row}}</td>
						<td>{{$fleetType->Seat_Column}}</td>
						<td>
							<button class="btn btn-primary" onclick="showForm({{$fleetType->id}}, '{{$fleetType->fleet_type}}', {{$fleetType->Seat_Row}}, {{$fleetType->Seat_Column}})">edit</button>
							<form action="/fleets/{{$fleetType->id}}" method="post" style="display: inline">
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
			function showForm(num, type, row, col) {
				actionAttValue = "/fleets/"+num;
				$('#editForm').attr("action", actionAttValue);
				$('#fleetEdit').attr("value", type);
				$('#rowEdit').attr("value", row);
				$('#colEdit').attr("value", col);
				$('#editForm>button').text("Edit " + type);
				$('#editForm').show(100);
			}
		</script>
	@else
		<div class="jumbotron"><h1>Fleet type not found. Add them from the form above.</h1></div>
	@endif
@endsection