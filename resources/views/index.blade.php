@extends('layouts.base')
@section('content')
	<main class="py-4 container">
		<div class="container text-sm-center py-5">
			<h1 class="display-1">Welcome to<br>larabus</h1>
			@if(Auth::guest())
				<a href="/login" class="btn btn-outline-primary">Login</a>
				<a href="/register" class="btn btn-outline-primary">Register</a>
				<br>
			@else
				<a href="/tickets/book" class="btn btn-outline-primary">Book Ticket</a>
			@endif
		</div>
	</main>
@endsection