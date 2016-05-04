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
				<h4>Add year</h4>
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
				{{ Form::open(array('url' => 'admin/addyear')) }}
					<div class="col-sm-3">
				    	{{ Form::text('number', '', array('placeholder'=>'Year Number (YYYY)', 'class'=>'form-control')) }}
				    </div>
				    <div class="col-sm-3">
				    	<button type="submit" class="btn btn-primary">Submit</button>
				    </div>
				{{ Form::close() }}
				</div>
			</div>
		</div>
		<div class="row">
			<br><br>
			<div class="col-xs-12">
				<h4>Years</h4>
			</div>
			@foreach ($years as $year)
			    <div class="col-xs-6 col-sm-3">
			    	<span class="number">{!! $year->number !!}</span>
			    	<button class="pull-right delete-year btn btn-default btn-xs" disabled>Delete</button>
			    </div>
			@endforeach
		</div>

	</div>
    
@stop