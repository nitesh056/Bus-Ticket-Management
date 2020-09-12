@extends('layouts.base')
@section('content')
    <h1 class="my-4">Book Ticket</h1>
    
    <form action="/tickets" method="POST">
		@csrf
		<div class="form-group">
			<label for="booking_date">Booking Date: </label>
			<input type="date" id="bookingDate" name="booking_date">
		</div>
        
        <div class="form-group">
            <label for="route">Routes:</label>
            <select class="form-control mr-sm-2" id="route" name="route">
                <option>------</option>
                @foreach($routes as $route)
                    <option value="{{$route->id}}">{{$route->starting_point}} - {{$route->destination_point}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="fleet">Fleets:</label>
            <select class="form-control mr-sm-2" id="fleet" name="fleet">
                <option>------</option>
                @foreach($fleets as $fleet)
                    <option value="{{$fleet->id}}">{{$fleet->fleet_type}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button type="button" class="btn btn-primary" onclick="checkTicket()">Check for ticket</button>
        </div>

        
        <div class="form-check mb-2" id="availableTickets" style="display:none;">
            Available Tickets:
            <div id="radioOption"></div>
        </div>
        
		<div class="form-group">
			<label for="no_of_tickets">Choose Number of ticket:</label>
			<input type="number" class="form-control col-sm-2" name="no_of_tickets">
        </div>
		
		<div class="form-group">
			<input type="submit" value="Book" class="btn btn-primary">
		</div>
	</form>

    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script defer>
        function checkTicket() {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': '<?php echo csrf_token() ?>'}
            });
            var formData = {
                'bookingDate' : $('#bookingDate').val(),
                'route' : $('#route').val(),
                'fleet' : $('#fleet').val()
            };
            $.ajax({
                type: 'POST',
                url: '/tickets/check',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    // console.log(data.msg);
                    data.messages.forEach(function(message) {
                        $('#radioOption').html("<input class='form-check-input' type='radio' name='1' value='" + message.id + "'> " + message.available_seats + " seats available for " + message.vehicle.vehicle + "<br>");
                    });
                    $('#availableTickets').show();
                },
                error: function (data) {
                    console.log("error");
                }
            });
        }
    </script>
@endsection
