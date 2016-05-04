@extends('layouts.master')

@section('title', 'Home')

@section('navbar')
    @parent
    <!-- Append content to navbar here if needed -->
@stop

@section('content')

	<section id="hero">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					[--Home Slider--]
				</div>		
			</div>
		</div>
	</section>
	<secton id="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#recent-reviews">Recently updated</a></li>
					  	<li><a data-toggle="tab" href="#top-rated">Top Rated</a></li>
					</ul>

					<div class="tab-content">
					  	<div id="recent-reviews" class="tab-pane fade in active">
					    	<ul class="no-bullets">
					    		@foreach ($models as $model)
					    		<a href="{{ URL::to('model/'.$model->year.'/'.$model->make_name.'/'.$model->name) }}"><li><div style="display: inline-block; width: 150px; height: 100px; background: url({{ asset(str_replace(' ','%20',$model->img_url)) }}) no-repeat center center; background-size: cover;"></div>
					    			<div class="model-name">{{ $model->make_name }} {{ $model->name }}</div>
					    			<div class="rating"><div class="avg"><strong>{{ $model->avg_rating }}</strong></div><div class="count">(Based on {{ $model->rating_count }} Ratings)</div>
					    			</div></li></a>
					    		@endforeach
					    	</ul>
					  	</div>

					  	<div id="top-rated" class="tab-pane fade">
					    	<ul class="no-bullets">
					    		@foreach ($top_models as $model)
					    		<a href="{{ URL::to('model/'.$model->year.'/'.$model->make_name.'/'.$model->name) }}"><li><div style="display: inline-block; width: 150px; height: 100px; background: url({{ asset(str_replace(' ','%20',$model->img_url)) }}) no-repeat center center; background-size: cover;"></div>
					    			<div class="model-name">{{ $model->make_name }} {{ $model->name }}</div>
					    			<div class="rating"><div class="avg"><strong>{{ $model->avg_rating }}</strong></div><div class="count">(Based on {{ $model->rating_count }} Ratings)</div>
					    			</div></li></a>
					    		@endforeach
					    	</ul>
					  	</div>
					</div>

					<a href="{{ URL::to('rankings') }}"><div class="view-all">
						<span>View All</span>
					</div></a>

				</div>
				@include("includes/right-menu")
			</div>
		</div>
	</secton>
    
@stop