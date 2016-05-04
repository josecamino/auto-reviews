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
			<br><br>
				<h4>Add make</h4>
				@if(count($errors) > 0)
					<div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
				<div class="row">
				{{ Form::open(array('url' => 'admin/addmake')) }}
					<div class="col-sm-3">
				    	{{ Form::text('name', '', array('placeholder'=>'Make Name', 'class'=>'form-control')) }}
				    </div>
				    <div class="col-sm-9">
				    	<button type="submit" class="btn btn-primary">Submit</button>
				    </div>
				{{ Form::close() }}
				</div>
			</div>
		</div>
		<div class="row">
			<br><br>
			<div class="col-xs-12">
				<h4>Makes</h4>
			</div>
			@foreach ($makes as $make)
			    <div class="col-xs-6 col-sm-3">
			    	<span class="make">{!! $make->name !!}</span>
			    	<button disabled class="pull-right delete-make btn btn-default btn-xs">Delete</button>
			    </div>
			@endforeach
		</div>

	</div>
    
@stop