@extends('layouts.admin-master')

@section('title', 'Admin Panel')

@section('navbar')
    @parent
    <!-- Append content to navbar here if needed -->
@stop

@section('content')

	@include("includes/adminbar")

	<div class="container">
		@if ($error)
		<div class="row">
			<div class="col-xs-12">
			<br><br>
				<h4>Review not found</h4>
			</div>
		</div>
		@else
			@if($model)
				@if($review)
				<div class="row">
					<div class="col-xs-12">
					<br><br>
						<h4>{{ $model->year }} {{ $model->make_name }} {{ $model->name }}</h4>
						<br>

						<h4>Edit Review</h4>

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
						{{ Form::open(array('url' => 'admin/models/'.$model->id.'/editreview/'.$review->id.'', 'id'=>'add-review-form')) }}
							<div class="col-xs-3">
								{{ Form::label('rating', 'Rating') }}
								{{ Form::text('rating', ''.$review->rating.'', array('class'=>'form-control')) }}
							</div>
							<div class="col-xs-3">
								{{ Form::label('out_of', 'Out of') }}
								{{ Form::text('out_of', '5', array('placeholder'=>'Out of', 'class'=>'form-control')) }}
							</div>
							<div class="col-xs-6">
								{{ Form::label('by', 'By') }}
								{{ Form::text('by', ''.$review->by.'', array('placeholder'=>'By', 'class'=>'form-control')) }}
							</div>
						    <div class="col-sm-12">
						    	{{ Form::label('url', 'URL') }}
						    	{{ Form::text('url', ''.$review->url.'', array('placeholder'=>'URL', 'class'=>'form-control')) }}
						    </div>
						    <div class="col-sm-12">
						    	{{ Form::label('excerpt', 'Excerpt') }}
						    	{{ Form::textarea('excerpt', ''.$review->excerpt.'', array('placeholder'=>'Excerpt', 'class'=>'form-control')) }}
						    </div>
						    <div class="col-sm-12">
						    	<button type="submit" class="btn btn-primary">Submit</button>
						    	<a href="{{ URL::to('admin/models/'.$model->id.'/reviews') }}" class="btn btn-default pull-right">Cancel</a>
						    </div>
						{{ Form::close() }}
						</div>
					</div>
				</div>
				@else
				<div class="row">
					<div class="col-xs-12">
					<br><br>
						<h4>Review not found</h4>
					</div>
				</div>
				@endif
			@else
				<div class="row">
					<div class="col-xs-12">
					<br><br>
						<h4>Model not found</h4>
					</div>
				</div>
			@endif
		@endif

	</div>
    
@stop