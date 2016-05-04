@extends('layouts.admin-master')

@section('title', 'Admin Panel')

@section('navbar')
    @parent
    <!-- Append content to navbar here if needed -->
@stop

@section('content')

	@include("includes/adminbar")

	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h3>Admin Panel Home</h3>
			</div>
		</div>
	</div>
	
@stop