@extends('layouts.master')

@section('title', 'Rankings')

@section('navbar')
    @parent
    <!-- Append content to navbar here if needed -->
@stop

@section('content')

<secton id="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<div id="rankings-form">
					<a id="view-all" href="{{ URL::to('rankings/results') }}"><h4>View all models</h4></a>
					<span>or</span>
					<br>
					<!-- Body Style -->
					<div id="body-style">
						<h5>Select a Body Style (optional)</h5>
						<div class="row cat-row">
							<div class="col-sm-3">
								<div class="cat" type="body">
									<h4>Convertible</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="body">
									<h4>Coupe</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="body">
									<h4>Hatchback</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="body">
									<h4>Sedan</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="body">
									<h4>SUV/Crossover</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="body">
									<h4>Truck</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="body">
									<h4>Van/Minivan</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="body">
									<h4>Wagon</h4>
								</div>
							</div>
						</div>
					</div>
					<!-- Category -->
					<div id="class">
						<h5>Select a class (optional)</h5>
						<div class="row cat-row">
							<div class="col-sm-3">
								<div class="cat" type="class">
									<h4>Economy</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="class">
									<h4>Luxury</h4>
								</div>
							</div>
						</div>
					</div>
					<!-- Size -->
					<div id="size">
						<h5>Select a size (optional)</h5>
						<div class="row cat-row">
							<div class="col-sm-3">
								<div class="cat" type="size">
									<h4>Subcompact</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="size"> 
									<h4>Compact</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="size">
									<h4>Mid-Size</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="size">
									<h4>Full-size</h4>
								</div>
							</div>
						</div>
					</div>
					<!-- Fuel type -->
					<div id="fuel-type">
						<h5>Select fuel type (optional)</h5>
						<div class="row cat-row">
							<div class="col-sm-3">
								<div class="cat" type="fuel">
									<h4>Gas</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="fuel">
									<h4>Diesel</h4>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="cat" type="fuel">
									<h4>Hybrid/Electric</h4>
								</div>
							</div>
						</div>
					</div>
					<!-- Sport -->
					<h5>Sport? (optional)</h5>
					<div class="row cat-row">
						<div class="col-sm-3">
							<div class="cat" type="sport">
								<h4>Sport</h4>
							</div>
						</div>
					</div>
					<!-- Continue -->
					<div id="continue">
						<div class="row">
							<div class="col-sm-12">
								<button class="btn btn-primary" id="btn-continue">Continue</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			@include("includes/right-menu")
		</div>
	</div>
</secton>
    
@stop