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
			<div class="col-xs-12">
			<br><br>
				<h4>Edit model</h4>
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

					{{ Form::open(array('url' => 'admin/models/'.$model->id, 'files'=>true)) }}
					<div class="col-sm-4">
						<label>Year</label>
						{{ Form::text('year', $model->year, array('class'=>'form-control', 'readonly')) }}
					</div>
					<div class="col-sm-4">
						<label>Make</label>
						{{ Form::text('make', $model->make_name, array('class'=>'form-control', 'readonly')) }}
					</div>
					<div class="col-sm-4">
						<label>Model *</label>
						{{ Form::text('name', $model->name, array('placeholder'=>'Model Name', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-4">
						<br>
						<label>Generation</label>
						{{ Form::text('gen', $model->gen, array('placeholder'=>'Gen Number', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-4">
						<br>
						<label>Category (check all that apply)</label>
						<br>
						@foreach($categories as $category)
							<?php $optionChecked = false; ?>
							@foreach ( $current_categories as $current_category )
								@if ($current_category->category_id == $category->id)
									<?php $optionChecked = true; break; ?>
								@endif
							@endforeach

							@if ($optionChecked)
								<input type="checkbox" name="category_group[]" value="{{ $category->id }}" checked> {{ $category->name }}<br>
							@else
								<input type="checkbox" name="category_group[]" value="{{ $category->id }}"> {{ $category->name }}<br>
							@endif
						@endforeach
					</div>
					<div class="col-sm-4">
						<br>
						<label>Body Style (check all that apply)</label>
						<br>
						@foreach($styles as $style)
							<?php $optionChecked = false; ?>
							@foreach ( $current_styles as $current_style )
								@if ($current_style->style_id == $style->id)
									<?php $optionChecked = true; break; ?>
								@endif
							@endforeach

							@if ($optionChecked)
								<input type="checkbox" name="style_group[]" value="{{ $style->id }}" checked> {{ $style->name }}<br>
							@else
								<input type="checkbox" name="style_group[]" value="{{ $style->id }}"> {{ $style->name }}<br>
							@endif
						@endforeach
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2">
						<br>
						<label>MSRP</label>
						{{ Form::number('msrp', $model->msrp, array('placeholder'=>'MSRP', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 col-xs-6">
						<br>
						<label>HP (min)</label>
						{{ Form::number('hp_min', $model->hp_min, array('placeholder'=>'Min', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-2 col-xs-6">
						<br>
						<label>HP (max)</label>
						{{ Form::number('hp_max', $model->hp_max, array('placeholder'=>'Max', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-2 col-xs-6">
						<br>
						<label>MPG City</label>
						{{ Form::number('mpg_city', $model->mpg_city, array('placeholder'=>'City', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-2 col-xs-6">
						<br>
						<label>MPG Road</label>
						{{ Form::number('mpg_road', $model->mpg_road, array('placeholder'=>'Road', 'class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<br>
						<label>Warranty</label>
						{{ Form::text('warranty', $model->warranty, array('placeholder'=>'Warranty', 'class'=>'form-control')) }}
					</div>
					<div class="col-sm-6">
						<br>
						<label>Engine options</label>
						{{ Form::text('engine_options', $model->engine_options, array('placeholder'=>'List options', 'class'=>'form-control')) }}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<br>
						<!-- <label>Image</label> -->
						<img class="img-responsive" src="{{ asset($model->img_url) }}">
						<label>Replace Image (*.jpg)</label>
						{!! Form::file('image') !!}
					</div>
					<div class="col-xs-12">
						<br><br>
						<button type="submit" class="btn btn-primary">Save</button>
						<button class="pull-right delete-model btn btn-default" data="{{ $model->id }}">Delete</button></li>
						<br><br>
					</div>
					{{ Form::close() }}
				</div>
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