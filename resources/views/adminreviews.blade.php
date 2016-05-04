@extends('layouts.admin-master')

@section('title', 'Admin Panel')

@section('navbar')
    @parent
    <!-- Append content to navbar here if needed -->
@stop

@section('content')

	@include("includes/adminbar")

	<div class="container">
		@if($model)
		<div class="row">
			<div class="col-xs-12 col-sm-4">
				<br><br>
				<h4>{{ $model->year }} {{ $model->make_name }} {{ $model->name }} (Gen {{ $model->gen }})</h4>
				<br>
			</div>
			<div class="col-xs-12 col-sm-4">
				<br>
				<p>Categories:</p>
				@foreach ($categories as $category)
					<span>{{ $category->name }} | </span>
				@endforeach
			</div>
			<div class="col-xs-12 col-sm-4">
				<br>
				<p>Styles:</p>
				@foreach ($styles as $style)
					<span>{{ $style->name }} | </span>
				@endforeach
			</div>
			<div class="col-xs-12 text-right">
				<br>
				<a href="{{ URL::to('admin/models/'.$model->id) }}" class="btn btn-default">Edit Model</a>
				<br><br>
			</div>
			<div class="col-xs-12">
				<hr>
				<h4>Add Review</h4>
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
				{{ Form::open(array('url' => 'admin/models/'.$model->id.'/addreview', 'id'=>'add-review-form')) }}
					<div class="col-xs-3">
						{{ Form::text('rating', '', array('placeholder'=>'Rating', 'class'=>'form-control')) }}
					</div>
					<div class="col-xs-3">
						{{ Form::text('out_of', '', array('placeholder'=>'Out of', 'class'=>'form-control')) }}
					</div>
					<div class="col-xs-6">
						{{ Form::text('by', '', array('placeholder'=>'By', 'class'=>'form-control')) }}
					</div>
				    <div class="col-sm-12">
				    	{{ Form::text('url', '', array('placeholder'=>'URL', 'class'=>'form-control')) }}
				    </div>
				    <div class="col-sm-12">
				    	{{ Form::textarea('excerpt', '', array('placeholder'=>'Excerpt', 'class'=>'form-control')) }}
				    </div>
				    <div class="col-sm-12">
				    	<button type="submit" class="btn btn-primary">Submit</button>
				    </div>
				{{ Form::close() }}
				</div>
			</div>
		</div>
		<div class="row">
			<br><br>
			<div class="col-xs-12">
				<h4>Reviews</h4>

				<?php $count = 0; ?>

				@foreach ($reviews as $review)

					@if ($count % 2 == 0)
						<div class="row">
					@endif

				    <div class="col-sm-6">
				    	@if ($review->rating)
				    		<p>{{ $review->rating }}</p>
				    	@else
				    		<p>No rating</p>
				    	@endif
				    	<p>By {{ $review->by }}</p>
				    	<p>Source: <a href="{{ $review->url }}" target="_blank">{{ $review->url }}</a></p>
				    	<p>{{ $review->excerpt }}</p>
				    	<a href="{{ URL::to('admin/models/'.$model->id.'/editreview/'.$review->id) }}" class="edit-review btn btn-default btn-xs">Edit</a>
				    	<button class="pull-right delete-model-review btn btn-default btn-xs" data="{{ $review->id }}">Delete</button>
				    </div>

				    @if ($count % 2 == 1)
				    	</div>
				    	<br>
				    @endif
				    <?php $count++; ?>

				@endforeach

				@if ($count % 2 != 0)
					</div>
				@endif
			</div>
		</div>
		@else
			<div class="row">
				<div class="col-xs-12">
				<br><br>
					<h4>Model not found</h4>
				</div>
			</div>
		@endif

	</div>
    
@stop