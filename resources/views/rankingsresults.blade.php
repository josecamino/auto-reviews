@extends('layouts.master')

@section('title', 'Results')

@section('navbar')
    @parent
    <!-- Append content to navbar here if needed -->
@stop

@section('content')

<?php 

	$YEARS = [2016, 2017];
	$models = [];
	$title = "";

	$cat = null;
	$body = null;
	if (isset($_GET['cat'])) {
		$cat = $_GET['cat'];
	}
	if (isset($_GET['body'])) {
		$body = $_GET['body'];
	}

	// If cat & body are empty show all
	if ($cat == null && $body == null) {
		$models = \DB::table('models')
		->where('rating_count', '>=', 3)
		->join('years_makes', 'models.year_make_id', '=', 'years_makes.id')
		->join('makes', 'makes.id', '=', 'years_makes.make_id')
		->join('years', 'years_makes.year_id', '=', 'years.id')
		->whereIn('years.number', $YEARS)
		->select('models.id', 'models.name', 'models.avg_rating', 'models.rating_count', 'models.img_url', 'makes.name as make_name', 'years.number as year')
		->orderBy('models.avg_rating', 'DESC')
		->get();

		$title = "Top Cars";
	}
	// else if cat is empty skip category query
	else if ($cat == null && $body != "") {
		$models = \DB::table('models')
		->where('rating_count', '>=', 3)
		->join('years_makes', 'models.year_make_id', '=', 'years_makes.id')
		->join('makes', 'makes.id', '=', 'years_makes.make_id')
		->join('years', 'years_makes.year_id', '=', 'years.id')
		->whereIn('years.number', $YEARS)
		->join('models_styles', 'models_styles.model_id', '=', 'models.id')
		->join('styles', 'styles.id', '=', 'models_styles.style_id')
		->where('styles.name', '=', $body)
		->select('models.id', 'models.name', 'models.avg_rating', 'models.rating_count', 'models.img_url', 'makes.name as make_name', 'years.number as year')
		->orderBy('models.avg_rating', 'DESC')
		->get();

		if ($body == "suv/crossover") {
			$title = "Top SUVs and Crossovers";
		}
		else if ($body == "van/minivan") {
			$title = "Top Vans and Minivans";
		}
		else {
			$title = "Top " . ucfirst($body) . "s";
		}
	}
	// else if body is empty skip body query
	else if ($body == null && $cat != "") {
		$categories = explode(",", $cat);
		$catCount = 0;

		if ($categories != null) {
			$catCount = count($categories);

			$models = \DB::table('models')
			->where('rating_count', '>=', 3)
			->join('years_makes', 'models.year_make_id', '=', 'years_makes.id')
			->join('makes', 'makes.id', '=', 'years_makes.make_id')
			->join('years', 'years_makes.year_id', '=', 'years.id')
			->whereIn('years.number', $YEARS)
			->join('models_categories', 'models_categories.model_id', '=', 'models.id')
			->join('categories', 'categories.id', '=', 'models_categories.category_id')
			->whereIn('categories.name', $categories)
			->select('models.id', 'models.name', 'models.avg_rating', 'models.rating_count', 'models.img_url', 'makes.name as make_name', 'years.number as year')
			->orderBy('models.avg_rating', 'DESC')
			->groupBy("models.id")
			->havingRaw("count(models.id) >= ".$catCount)
			->get();

			$title = "Top";
			for ($i=0; $i<$catCount; $i++) {
				$title .= " " . ucfirst($categories[$i]);
			}
			$title .= " Cars";
		}
	}
	else {
		$categories = explode(",", $cat);
		$catCount = 0;

		if ($categories != null) {
			$catCount = count($categories);

			$models = \DB::table('models')
			->where('rating_count', '>=', 3)
			->join('years_makes', 'models.year_make_id', '=', 'years_makes.id')
			->join('makes', 'makes.id', '=', 'years_makes.make_id')
			->join('years', 'years_makes.year_id', '=', 'years.id')
			->whereIn('years.number', $YEARS)
			->join('models_categories', 'models_categories.model_id', '=', 'models.id')
			->join('categories', 'categories.id', '=', 'models_categories.category_id')
			->whereIn('categories.name', $categories)
			->join('models_styles', 'models_styles.model_id', '=', 'models.id')
			->join('styles', 'styles.id', '=', 'models_styles.style_id')
			->where('styles.name', '=', $body)
			->select('models.id', 'models.name', 'models.avg_rating', 'models.rating_count', 'models.img_url', 'makes.name as make_name', 'years.number as year')
			->orderBy('models.avg_rating', 'DESC')
			->groupBy("models.id")
			->havingRaw("count(models.id) >= ".$catCount)
			->get();

			$title = "Top";
			for ($i=0; $i<$catCount; $i++) {
				$title .= " " . ucfirst($categories[$i]);
			}

			if ($body == "suv/crossover") {
				$title .= " SUVs and Crossovers";
			}
			else if ($body == "van/minivan") {
				$title .= " Vans and Minivans";
			}
			else {
				$title .= " " . ucfirst($body) . "s";
			}
			
		}
	}
?>

<secton id="results-content">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 results">
				<h3>{{ $title }}</h3>
				@if ($models)
					<ul class="no-bullets">
					@foreach ($models as $model)
					<a href="{{ URL::to('model/'.$model->year.'/'.$model->make_name.'/'.$model->name) }}"><li><div style="display: inline-block; width: 150px; height: 100px; background: url({{ asset(str_replace(' ','%20',$model->img_url)) }}) no-repeat center center; background-size: cover;"></div>
						<div class="model-name">{{ $model->make_name }} {{ $model->name }}</div>
						<div class="rating"><div class="avg"><strong>{{ $model->avg_rating }}</strong></div><div class="count">(Based on {{ $model->rating_count }} Ratings)</div>
						</div></li></a>
					@endforeach
					</ul>
				@endif
			</div>
			@include("includes/right-menu")
		</div>
	</div>
</secton>
    
@stop