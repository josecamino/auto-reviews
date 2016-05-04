<?php

namespace App\Http\Controllers;

use Auth;
use View;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Input;

// Models
use App\Year;
use App\Make;
use App\Model;
use App\YearMake;
use App\Review;
use App\Category;
use App\Style;
use App\ModelCategory;
use App\ModelStyle;
use Image;

class AdminController extends Controller
{
	protected function showAdmin() {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			return View::make('admin');
		}

    	return Redirect::to('auth/login');
	}

	//////////////////////////////////////////////////////////////////
	//                            YEARS                             // 
	//////////////////////////////////////////////////////////////////

	// Get all years and pass the data to 'adminyears' view
	protected function showAllYears() {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			// Get all vehicle years
			$years = Year::orderBy('number', 'DESC')->get();
		    return View::make('adminyears')->withYears($years);
		}

    	return Redirect::to('auth/login');
	}

	// Add year to years table
	protected function addYear() {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
	        $rules = array(
	            'number'	=> 'required|integer|unique:years|min:1900|max:2030'
	        );
	        $validator = Validator::make(Input::all(), $rules);

	        if ($validator->fails()) {
	            $messages = $validator->messages();

	            return Redirect::to('admin/years')
	                ->withErrors($validator)->withInput();

	        } else {
	        	try {
	                Year::create([
	    	            'number' => trim(Input::get('number'))
	    	        ]);
	        	} catch( \Illuminate\Database\QueryException $e){
	        	    return Redirect::to('admin/years')->withErrors($validator);
	        	}
	        }
	    }

        return Redirect::to('admin/years');
	}

	// Delete year from years table. TODO: Make sure this year is not being used before attempting to delete
	protected function deleteYear() {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			if($_POST['year']) {

				$year = Year::where('number', $_POST['year']);

				if ($year) {
					if ($year->delete()) {
						return "Year deleted successfulfy";
					}
				}
			}
		}
		
		return false;
	}

	//////////////////////////////////////////////////////////////////
	//                            MAKES                             // 
	//////////////////////////////////////////////////////////////////

	// Get all makes and pass the data to 'adminmakes' view
	protected function showAllMakes() {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			// Get all vehicle makes
			$makes = Make::orderBy('name', 'ASC')->get();
		    return View::make('adminmakes')->withMakes($makes);
		}

    	return Redirect::to('auth/login');
	}

	// Add make to makes table
	protected function addMake() {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
	        $rules = array(
	            'name'	=> 'required|unique:makes'
	        );
	        $validator = Validator::make(Input::all(), $rules);

	        if ($validator->fails()) {
	            $messages = $validator->messages();

	            return Redirect::to('admin/makes')
	                ->withErrors($validator)->withInput();

	        } else {
	        	try {
		            Make::create([
		  	        	'name' => trim(Input::get('name'))
		  	        ]);
	        	} catch( \Illuminate\Database\QueryException $e){
	        	    return Redirect::to('admin/makes')->withErrors($validator);
	        	}
	            
	        }
	    }

        return Redirect::to('admin/makes');
	}

	// Delete make from makes table. TODO: Make sure this make is not in use before attempting to delete
	protected function deleteMake() {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			if($_POST['make']) {

				$make = Make::where('name', $_POST['make']);

				if ($make) {
					if ($make->delete()) {
						return "Make deleted successfulfy";
					}
				}
			}
		}
		
		return false;
	}

	//////////////////////////////////////////////////////////////////
	//                           MODELS                             // 
	//////////////////////////////////////////////////////////////////

	// Get all models and pass the data to 'adminmodels' view
	protected function showAllModels() {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			// Get all vehicle models
			$years = Year::select('number')->get();
			$makes = Make::select('name')->get();

			$models = \DB::table('models')
			->join('years_makes', 'years_makes.id', '=', 'models.year_make_id')
            ->join('years', 'years.id', '=', 'years_makes.year_id')
            ->join('makes', 'makes.id', '=', 'years_makes.make_id')
            ->select('models.id', 'models.name', 'makes.name as make_name', 'years.number as year')
            ->get();

            $categories = Category::orderBy('name', 'ASC')->get();
            $styles = Style::orderBy('name', 'ASC')->get();

		    return View::make('adminmodels')->withModels($models)->withYears($years)->withMakes($makes)->withCategories($categories)->withStyles($styles);
		}

    	return Redirect::to('auth/login');
	}

	// Add make to makes table
	protected function addModel() {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
	        $rules = array(
	            'name'	=> 'required',
	            'gen' => 'integer|min:1|max:15',
	            'image' => 'required'
	        );
	        $validator = Validator::make(Input::all(), $rules);

	        if ($validator->fails()) {
	            $messages = $validator->messages();

	            return Redirect::to('admin/models')
	                ->withErrors($validator)->withInput();

	        } else {
	        	try {
	        		$inputYear = Input::get('year');
	        		$inputMake = Input::get('make');
	        		$inputName = trim(Input::get('name'));
	        		$url = null;

	        		// checking file is valid.
	        		if (Input::file('image')->isValid()) {
	        		  $extension = Input::file('image')->getClientOriginalExtension();
	        		  if ($extension == 'jpg' || $extension == 'jpeg') {

	        		  	$destinationPath = public_path().'/img/auto-images/'.$inputMake;
	        		  	// If destination folder doesn't exist, create it.
	        		  	if (!file_exists($destinationPath)) {
	        		  		mkdir($destinationPath);
	        		  	}

	        		  	$fileName = $inputName.'_'.$inputYear.'.jpg'; 
	        		  	// Save image file
	        		  	$path = Input::file('image')->move($destinationPath, $fileName);

	        		  	$width = Image::make($path)->width();

	        		  	if ($width > 800) {
	        		  		$img = Image::make($path)->resize(800, null, function ($constraint) {
				                $constraint->aspectRatio();
				            })->save();
	        		  	}

	        		  	$url = 'img/auto-images/'.$inputMake.'/'.$fileName;
	        		  }
	        		  else {
	        		  	return Redirect::to('admin/models')->withInput();
	        		  }
	        		}
	        		else {
	        		  return Redirect::to('admin/models')->withInput();
	        		}

	        		$year = Year::where('number', $inputYear)->first();
	        		$make = Make::where('name', $inputMake)->first();

	        		$yearMake = YearMake::firstOrCreate(array('year_id' => $year->id, 'make_id' => $make->id));
	        		$model = Model::firstOrCreate(array('year_make_id' => $yearMake->id, 'name' => $inputName, 'gen' => Input::get('gen'), 'img_url' => $url, 'msrp' => Input::get('msrp'), 'hp_min' => Input::get('hp_min'), 'hp_max' => Input::get('hp_max'), 'mpg_city' => Input::get('mpg_city'), 'mpg_road' => Input::get('mpg_road'), 'warranty' => Input::get('warranty'), 'engine_options' => Input::get('engine_options')));

	        		$categories = Input::get('category_group');

	        		if ($categories != null) {
	        			foreach ($categories as $category_id) {
	        				$modelCategory = ModelCategory::firstOrCreate(array('model_id' => $model->id, 'category_id' => $category_id));
	        			}
	        		}

	        		$styles = Input::get('style_group');

	        		if ($styles != null) {
	        			foreach ($styles as $style_id) {
	        				$modelStyle = ModelStyle::firstOrCreate(array('model_id' => $model->id, 'style_id' => $style_id));
	        			}
	        		}

	        	} catch( \Illuminate\Database\QueryException $e){
	        	   return Redirect::to('admin/models')->withErrors($validator);
	        	}
	            
	        }
	    }

        return Redirect::to('admin/models');
	}

	// Delete model from models table. TODO: Make sure this model is not in use before attempting to delete
	protected function deleteModel() {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			if($_POST['model']) {

				$model = Model::find($_POST['model']);

				if ($model != null) {

					// Delete model categories and styles
					$modelCategories = ModelCategory::where('model_id', $model->id)->delete();
					$modelStyles = ModelStyle::where('model_id', $model->id)->delete();
					// Delete Reviews
					$reviews = Review::where('model_id', $model->id)->delete();
					
					// Delete Image
					$yearMake = YearMake::find($model->year_make_id);
					$year = Year::find($yearMake->year_id);
					$make = Make::find($yearMake->make_id);

					$imageName = public_path().'/img/auto-images/'.$make->name.'/'.$model->name.'_'.$year->number.'.jpg';

					if (file_exists($imageName)) {
						$imageDeleted = unlink($imageName);
					}

					// Delete Model
					if ($model->delete()) {
						return "Success";
					}
				}
			}
		}
		
		return Redirect::to('admin/models');
	}

	//////////////////////////////////////////////////////////////////
	//                           REVIEWS                            //
	//////////////////////////////////////////////////////////////////

	protected function showModelReviews($id) {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			// Get the model
            $model = \DB::table('models')
            ->where('models.id', '=', $id)
			->join('years_makes', 'years_makes.id', '=', 'models.year_make_id')
            ->join('years', 'years.id', '=', 'years_makes.year_id')
            ->join('makes', 'makes.id', '=', 'years_makes.make_id')
            ->select('models.id', 'models.name', 'models.gen', 'makes.name as make_name', 'years.number as year')
            ->get();

			// Get all reviews for the given model
			$reviews = \DB::table('reviews')
			->where('reviews.model_id', '=', $id)
			->join('models', 'models.id', '=', 'reviews.model_id')
			->join('years_makes', 'years_makes.id', '=', 'models.year_make_id')
            ->join('years', 'years.id', '=', 'years_makes.year_id')
            ->join('makes', 'makes.id', '=', 'years_makes.make_id')
            ->select('reviews.id', 'reviews.rating', 'reviews.by', 'reviews.url', 'reviews.excerpt', 'models.name as model_name', 'makes.name as make_name', 'years.number as year')
            ->get();

            // Get all categories that this model belongs to
            $categories = \DB::table('models_categories')
            ->where('models_categories.model_id', '=', $id)
            ->join('categories', 'models_categories.category_id', '=', 'categories.id')
            ->select('categories.name')
            ->orderBy('categories.name', 'ASC')
            ->get();

            // Get all body styles that this model is available in
            $styles = \DB::table('models_styles')
            ->where('models_styles.model_id', '=', $id)
            ->join('styles', 'models_styles.style_id', '=', 'styles.id')
            ->select('styles.name')
            ->orderBy('styles.name', 'ASC')
            ->get();

		    return View::make('adminreviews')->withReviews($reviews)->withModel($model[0])->withCategories($categories)->withStyles($styles);
		}

    	return Redirect::to('auth/login');
	}


	// Add review to reviews table
	protected function addModelReview($id) {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			$rating = Input::get('rating');

	        $rules = array(
	        	'rating'	=> 'numeric|min:0|max:100',
	        	'out_of'	=> 'numeric|min:'.$rating.'|max:100',
	            'by'		=> 'required',
	            'url'		=> 'required|unique:reviews'
	        );
	        $validator = Validator::make(Input::all(), $rules);

	        if ($validator->fails()) {
	            $messages = $validator->messages();

	            return Redirect::to('admin/models/'.$id.'/reviews')
	                ->withErrors($validator)->withInput();

	        } else {
	        	try {

	        		$rating = Input::get('rating');
	        		$out_of = Input::get('out_of');
	        		$stored_rating = null;

	        		if ( $rating && $out_of ) {
	        			$stored_rating = ($rating * 10) / $out_of;
	        		}

	        		$newReview = Review::create([
	        			'model_id' => $id,
	        			'rating' => $stored_rating,
	    	            'by' => trim(Input::get('by')),
	    	            'url' => trim(Input::get('url')),
	    	            'excerpt' => Input::get('excerpt')
	    	        ]);

	    	        $reviews = Review::where('model_id', $id)->get();
	    	        $total_rating = 0;
	    	        $rating_count = 0;
    	        	foreach($reviews as $review) {
    	        		if ($review->rating != null) {
    	        			$total_rating += $review->rating;
    	        			$rating_count++;
    	        		}
    	        	}

    	        	$model = Model::find($id);
    	        	$model->avg_rating = $total_rating/$rating_count;
    	        	$model->rating_count = $rating_count;
    	        	$model->save();

	        	} catch( \Illuminate\Database\QueryException $e){
	        	   return Redirect::to('admin/models/'.$id.'/reviews')->withErrors($validator);
	        	}
	            
	        }
	    }

        return Redirect::to('admin/models/'.$id.'/reviews');
	}


	// Delete model review from reviews table.
	protected function deleteModelReview($id, $review) {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			if($_POST['review']) {

				$review = Review::find($_POST['review']);

				if ($review) {

					if($review->delete()) {
						// Update average rating
						$reviews = Review::where('model_id', $id)->get();
						$model = Model::find($id);

						if (count($reviews) > 0) {
							$total_rating = 0;
							$rating_count = 0;
							foreach($reviews as $rev) {
							    if ($rev->rating != null) {
							        $total_rating += $rev->rating;
							        $rating_count++;
							    }
							}
							$model->avg_rating = $total_rating/$rating_count;
							$model->rating_count = $rating_count;
							$model->save();
						}
						else {
							$model->avg_rating = null;
							$model->rating_count = 0;
							$model->save();
						}
						

						return "Review deleted successfulfy";
					}
				}
			}
		}
		
		return false;
	}


	protected function viewModelReview($id, $review) {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			// Get the model
            $model = \DB::table('models')
            ->where('models.id', '=', $id)
			->join('years_makes', 'years_makes.id', '=', 'models.year_make_id')
            ->join('years', 'years.id', '=', 'years_makes.year_id')
            ->join('makes', 'makes.id', '=', 'years_makes.make_id')
            ->select('models.id', 'models.name', 'makes.name as make_name', 'years.number as year')
            ->get();

			// Get the review
			$review = Review::find($review);

			if ($review) {
				if($review->model_id == $id) {
					return View::make('admineditreview')->withReview($review)->withModel($model[0])->withError(null);
				}
			}
			
		    return View::make('admineditreview')->withError("The review was not found");
		}

    	return Redirect::to('auth/login');
	}


	protected function editModelReview($id, $reviewID) {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
			// Get the review
			$updatedReview = Review::find($reviewID);

			if ($updatedReview) {

				$rating = Input::get('rating');

		        $rules = array(
		        	'rating'	=> 'numeric|min:0|max:100',
		        	'out_of'	=> 'numeric|min:'.$rating.'|max:100',
		            'by'		=> 'required',
		            'url'		=> 'required'
		        );
		        $validator = Validator::make(Input::all(), $rules);

		        if ($validator->fails()) {
		            $messages = $validator->messages();

		            return Redirect::to('admin/models/'.$id.'/editreview/'.$reviewID)
		                ->withErrors($validator);

		        } else {
		        	try {

		        		$rating = Input::get('rating');
		        		$out_of = Input::get('out_of');
		        		$stored_rating = null;

		        		if ( $rating && $out_of ) {
		        			$stored_rating = ($rating * 10) / $out_of;
		        		}

		        		$updatedReview->rating = $stored_rating;
		        		$updatedReview->by = trim(Input::get('by'));
		        		$updatedReview->url = trim(Input::get('url'));
		        		$updatedReview->excerpt = Input::get('excerpt');
		        		$updatedReview->save();

		    	        $reviews = Review::where('model_id', $id)->get();
		    	        $total_rating = 0;
		    	        $rating_count = 0;
	    	        	foreach($reviews as $review) {
	    	        		if ($review->rating != null) {
	    	        			$total_rating += $review->rating;
	    	        			$rating_count++;
	    	        		}
	    	        	}

	    	        	$model = Model::find($id);
	    	        	$model->avg_rating = $total_rating/$rating_count;
	    	        	$model->rating_count = $rating_count;
	    	        	$model->save();

		        		return Redirect::to('admin/models/'.$id.'/reviews');

		        	} catch( \Illuminate\Database\QueryException $e){
		        	   return Redirect::to('admin/models/'.$id.'/editreview/'.$reviewID)->withErrors($validator);
		        	}
		        }
			}
			
		    return Redirect::to('admin/models/'.$id.'/editreview/'.$reviewID)->withError("The review was not found");
		}
	}


	//////////////////////////////////////////////////////////////////
	//                            MODEL                             // 
	//////////////////////////////////////////////////////////////////

	protected function showModel($id) {

		if(Auth::user() && Auth::user()->role == 'admin') {

			// Get the model
            $model = \DB::table('models')
            ->where('models.id', '=', $id)
			->join('years_makes', 'years_makes.id', '=', 'models.year_make_id')
            ->join('years', 'years.id', '=', 'years_makes.year_id')
            ->join('makes', 'makes.id', '=', 'years_makes.make_id')
            ->select('models.id', 'models.name', 'models.gen', 'models.msrp', 'models.hp_min', 'models.hp_max', 'models.mpg_city', 'models.mpg_road', 'models.warranty', 'models.engine_options', 'models.img_url', 'makes.name as make_name', 'years.number as year')
            ->get();

            // Get all categories that this model belongs to
            $currentCategories = \DB::table('models_categories')
            ->where('models_categories.model_id', '=', $id)
            ->join('categories', 'models_categories.category_id', '=', 'categories.id')
            ->select('categories.id as category_id')
            ->get();

            // Get all body styles that this model is available in
            $currentStyles = \DB::table('models_styles')
            ->where('models_styles.model_id', '=', $id)
            ->join('styles', 'models_styles.style_id', '=', 'styles.id')
            ->select('styles.id as style_id')
            ->get();

            $categories = Category::orderBy('name', 'ASC')->get();
            $styles = Style::orderBy('name', 'ASC')->get();

		    return View::make('adminmodel')->withModel($model[0])->withCategories($categories)->withStyles($styles)->withCurrentCategories($currentCategories)->withCurrentStyles($currentStyles);
		}

    	return Redirect::to('auth/login');
	}	


	// Add make to makes table
	protected function editModel($id) {

		if(Auth::user() && Auth::user()->role == 'admin')
		{
	        $rules = array(
	            'name'	=> 'required',
	            'gen' => 'integer|min:1|max:15'
	        );
	        $validator = Validator::make(Input::all(), $rules);

	        if ($validator->fails()) {
	            $messages = $validator->messages();

	            return Redirect::to('admin/models/'.$id)
	                ->withErrors($validator);

	        } else {
	        	try {

	        		$inputYear = Input::get('year');
	        		$inputMake = Input::get('make');
	        		$inputName = trim(Input::get('name'));
	        		$url = null;

	        		// checking file is valid.
	        		if (Input::hasFile( 'image' )) {
		        		if (Input::file('image')->isValid()) {
		        		  $extension = Input::file('image')->getClientOriginalExtension();
		        		  if ($extension == 'jpg' || $extension == 'jpeg') {

		        		  	$destinationPath = public_path().'/img/auto-images/'.$inputMake;
		        		  	// If destination folder doesn't exist, create it.
		        		  	if (!file_exists($destinationPath)) {
		        		  		mkdir($destinationPath);
		        		  	}

		        		  	$fileName = $inputName.'_'.$inputYear.'.jpg'; 
		        		  	// Save image file
		        		  	$path = Input::file('image')->move($destinationPath, $fileName);

		        		  	$width = Image::make($path)->width();

		        		  	if ($width > 800) {
		        		  		$img = Image::make($path)->resize(800, null, function ($constraint) {
					                $constraint->aspectRatio();
					            })->save();
		        		  	}

		        		  	$url = 'img/auto-images/'.$inputMake.'/'.$fileName;
		        		  }
		        		  else {
		        		  	return Redirect::to('admin/models')->withInput();
		        		  }
		        		}
		        		else {
		        		  return Redirect::to('admin/models')->withInput();
		        		}
	        		}


	        		// Delete existing categories and models
	        		$currentCategories = ModelCategory::where('model_id', $id)->delete();
	        		$currentStyles = ModelStyle::where('model_id', $id)->delete();

	        		// Update fields
	        		$model = Model::find($id);
	        		$model->name = $inputName;
	        		$model->gen = Input::get('gen');
	        		$model->msrp = Input::get('msrp');
	        		$model->hp_min = Input::get('hp_min');
	        		$model->hp_max = Input::get('hp_max');
	        		$model->mpg_city = Input::get('mpg_city');
	        		$model->mpg_road = Input::get('mpg_road');
	        		$model->warranty = Input::get('warranty');
	        		$model->engine_options = Input::get('engine_options');

	        		if ($url != null) {
	        			$model->img_url = $url;
	        		}
	        		$model->save();

	        		// Add new categories and styles
	        		$categories = Input::get('category_group');
	        		if ($categories != null) {
	        			foreach ($categories as $category_id) {
	        				$modelCategory = ModelCategory::firstOrCreate(array('model_id' => $model->id, 'category_id' => $category_id));
	        			}
	        		}
	        		$styles = Input::get('style_group');
	        		if ($styles != null) {
	        			foreach ($styles as $style_id) {
	        				$modelStyle = ModelStyle::firstOrCreate(array('model_id' => $model->id, 'style_id' => $style_id));
	        			}
	        		}

	        	} catch( \Illuminate\Database\QueryException $e){
	        	   return Redirect::to('admin/models')->withErrors($validator);
	        	}
	            
	        }
	    }

        return Redirect::to('admin/models/'.$id.'/reviews');
	}

}