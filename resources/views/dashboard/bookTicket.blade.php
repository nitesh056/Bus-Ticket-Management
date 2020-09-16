@extends('layouts.base')
@section('content')
    <h1 class="my-4">Book Ticket</h1>
    
    <form action="/tickets" method="POST">
		@csrf
		<div class="form-group">
			<label for="booking_date">Booking Date: </label><br>
			<input type="date" id="bookingDate" name="booking_date" required>
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
            <span class="pl-2" id="noTickets" style="display:none;">
                No tickets available
            </span>
        </div>
        
        <div class="form-group" id="availableTickets" style="display:none;">
            <label for="radioOption">Available Tickets:</label>
            <div class="form-check mb-2" id="radioOption"></div>

            <label for="radioOption">Choose YourSeat:</label>
            <div class="form-check" id="vehicleLayout"></div>
            <div style="display: none;" id="vehicleLayoutsHidden"><div id="all"></div><div id="new"></div></div>
            
            <div class="form-group">
                <input type="submit" value="Book" class="btn btn-primary">
            </div>
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
                success: function(data){
                    $('#radioOption').html("");
                    $('#noTickets').hide();
                    $('#availableTickets').hide();
                    emptyLayout();
                    if (data.listTickets.length == 0) {
                        $('#noTickets').show();
                    }else{
                        data.listTickets.forEach(function(message){
                            $('#radioOption').append("<input class='form-check-input' id='' type='radio' name='trip' value='" + message.id + "' onclick='displayAllocatedSeats("+ message.row +","+ message.column +",[" + message.allocated_seats+ "])'> " + message.available_seats + " seats available for " + message.vehicle.vehicle + "<br>");
                        });
                        $('#availableTickets').show();
                    }
                },
                error: function (data) {
                    console.log("Error from the server");
                    $('#noTickets').show();
                }
            });
        }

        function displayAllocatedSeats(row, col, list){
            emptyLayout();
            index = 0
            for (let i = 0; i < row; i++) {
                for (let j = 0; j < col; j++) {
                    if (list[index] == 0) {
                        $('#vehicleLayout').append("<input class='mr-1 seat' style='cursor:pointer;' type='checkbox' value='"+index+"'>");
                        $('#all').append("<input type='checkbox' name='all_allocated_seats[]' value='0' checked>");
                    } else {
                        $('#vehicleLayout').append("<input class='mr-1 seat' style='cursor:pointer;' type='checkbox' disabled>");
                        $('#all').append("<input type='checkbox' name='all_allocated_seats[]' value='1' checked>");
                    }
                    $('#new').append("<input type='checkbox' name='new_allocated_seats[]' value='0' checked>");
                    
                    index++;
                }
                $('#vehicleLayout').append('<br>');
            }
        }

        function emptyLayout() {
            $("#all").empty();
            $("#new").empty();
            $('#vehicleLayout').empty();
        }

        $(document).ready(function(){
            $(document).on('click', '.seat', function(){
                place = $(this).val();
                newAllocatedSeats = $('#new').children()[place];
                allAllocatedSeats = $('#all').children()[place];
                if ($(this).is(":checked")){
                    $(newAllocatedSeats).attr('value', 1);
                    $(allAllocatedSeats).attr('value', 1);
                    console.log(allAllocatedSeats);
                    console.log(newAllocatedSeats);
                }
                else {
                    $(newAllocatedSeats).attr('value', 0);
                    $(allAllocatedSeats).attr('value', 1);
                    console.log(allAllocatedSeats);
                    console.log(newAllocatedSeats);
                }
            });
        });
    </script>
@endsection
