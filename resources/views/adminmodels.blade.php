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
				<h4>Add model</h4>
				<div class="row">
					@if(count($errors) > 0)
						<div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif

					{{ Form::open(array('url' => 'admin/addmodel', 'files'=>true)) }}
					<div class="col-sm-4">
						<label>Year</label>
						<select name="year" id="year" class="form-control">
						@foreach($years as $year)
						<option value="{{ $year->number }}">{{ $year->number }}</option>
						@endforeach
						</select>
					</div>
					<div class="col-sm-4">
						<label>Make</label>
						<select name="make" id="make" class="form-control">
						@foreach($makes as $make)
						<option value="{{ $make->name }}">{{ $make->name }}</option>
						@endforeach
						</select>
					</div>
					<div class="col-sm-4">
						<label>Model *</label>
						{{ Form::text('name', '', array('placeholder'=>'Model Name', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-4">
						<br>
						<label>Generation</label>
						{{ Form::text('gen', '', array('placeholder'=>'Gen Number', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-4">
						<br>
						<label>Category (check all that apply)</label>
						<br>
						@foreach($categories as $category)
						<input type="checkbox" name="category_group[]" value="{{ $category->id }}"> {{ $category->name }}<br>
						@endforeach
					</div>
					<div class="col-sm-4">
						<br>
						<label>Body Style (check all that apply)</label>
						<br>
						@foreach($styles as $style)
						<input type="checkbox" name="style_group[]" value="{{ $style->id }}"> {{ $style->name }}<br>
						@endforeach
					</div>
				</div>
				<div class="row">	
					<div class="col-sm-2">
						<br>
						<label>MSRP</label>
						{{ Form::number('msrp', '', array('placeholder'=>'MSRP', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 col-xs-6">
						<br>
						<label>HP (min)</label>
						{{ Form::number('hp_min', '', array('placeholder'=>'Min', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-2 col-xs-6">
						<br>
						<label>HP (max)</label>
						{{ Form::number('hp_max', '', array('placeholder'=>'Max', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 col-xs-6">
						<br>
						<label>MPG City</label>
						{{ Form::number('mpg_city', '', array('placeholder'=>'City', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-2 col-xs-6">
						<br>
						<label>MPG Road</label>
						{{ Form::number('mpg_road', '', array('placeholder'=>'Road', 'class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<br>
						<label>Warranty</label>
						{{ Form::text('warranty', '', array('placeholder'=>'Warranty', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-6">
						<br>
						<label>Engine options</label>
						{{ Form::text('engine_options', '', array('placeholder'=>'List options', 'class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<br>
						<label>Upload Image (*.jpg)</label>
						{!! Form::file('image') !!}
					</div>
					<div class="col-xs-12">
						<br><br>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<br><br>
			<div class="col-xs-12">
				<h4>Models</h4>
			</div>
			
			@foreach ($years as $year)
				<div class="col-xs-12">
					<h4>{{ $year->number }}</h4>

					<?php $count = 0; ?>

					@foreach ($makes as $make)

						@if ($count % 4 == 0)
							<div class="row">
						@endif

						<div class="col-xs-6 col-sm-3">
							<h5>{{ $make->name }}</h5>
							<ul>
								@foreach ($models as $model)
									@if ($model->year == $year->number && $model->make_name == $make->name)
										<li class="model"><a href="{{ URL::to('admin/models/'.$model->id.'/reviews') }}">{{ $model->name }}</a>
									@endif
								@endforeach
							</ul>
						</div>

					@if ($count % 4 == 3)
					</div>
					@endif
					<?php $count++; ?>

					@endforeach

					@if ($count % 4 != 0)
					</div>
					@endif

				</div>
			@endforeach
			
		</div>

	</div>
    
@stop