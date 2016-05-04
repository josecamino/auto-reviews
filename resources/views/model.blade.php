@extends('layouts.master')

@section('title', 'Model')

@section('navbar')
    @parent
    <!-- Append content to navbar here if needed -->
@stop

@section('content')

	<secton id="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div style="display: inline-block; width: 100%; height: 350px; background: url({{ asset(str_replace(' ','%20',$model->img_url)) }}) no-repeat center center; background-size: cover;"></div>
				</div>
				<div class="col-sm-6">
					<h4>Model Year: {{ $model->year }}</h4>
					<h4>Make: {{ $model->make_name }}</h4>
					<h4>Model: {{ $model->name }}</h4>
					<br>
					<h4>Average Rating: {{ $model->avg_rating }}</h4>
					<h4>Number of Reviews: {{ $model->rating_count }}</h4>
					<br>

					@if ($model->msrp == 0)
						<p><strong>MSRP: </strong>N/A</p>
					@else
						<p><strong>MSRP: </strong>Starting at ${{ $model->msrp }}</p>
					@endif

					@if ($model->hp_min == 0 || $model->hp_max == 0)
						<p><strong>BHP: </strong>N/A</p>
					@elseif ($model->hp_min == $model->hp_max)
						<p><strong>BHP: </strong>{{ $model->hp_min }}</p>
					@else
						<p><strong>BHP: </strong>{{ $model->hp_min }} to {{ $model->hp_max }}</p>
					@endif
					
					@if ($model->mpg_city == 0 || $model->mpg_road == 0)
						<p><strong>MPG: </strong>N/A</p>
					@else
						<p><strong>MPG: </strong>Up to {{ $model->mpg_city }} city / {{ $model->mpg_road }} highway</p>
					@endif


					@if ($model->engine_options == "")
						<p><strong>Engine Options: </strong>N/A</p>
					@else
						<p><strong>Engine Options: </strong>{{ $model->engine_options }}</p>
					@endif
				</div>
				<div class="col-xs-12">
					
				</div>
			</div>
		</div>
	</secton>

	<section id="reviews">
		<div class="container">
			<div class="row">
				@foreach($reviews as $review)
				<div class="col-xs-12 review-wrapper">
					<div class="review">
						<div class="rating">{{ $review->rating }}</div>
						<span class="reviewer">{{ $review->by }}</span>
						<p class="excerpt text-center">"{{ $review->excerpt }}"</p>
						<div class="read-more text-right"><a href="{{ $review->url }}" target="_blank">Read more ></a></div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</section>
    
@stop