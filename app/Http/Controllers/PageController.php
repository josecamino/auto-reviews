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

class PageController extends Controller
{
	const YEARS = [2016, 2017];

	//////////////////////////////////////////////////////////////////
	//                          HOME PAGE                           // 
	//////////////////////////////////////////////////////////////////
	protected function showHome() {

		// Get recently updated models (current model year on the market) // TODO: This currently selects both previous and last year. Make it so it returns previous or last only.
		$updatedModels = \DB::table('models')
		->where('rating_count', '>=', 3)
		->join('years_makes', 'models.year_make_id', '=', 'years_makes.id')
		->join('makes', 'makes.id', '=', 'years_makes.make_id')
		->join('years', 'years_makes.year_id', '=', 'years.id')
		->whereIn('years.number', self::YEARS)
		->select('models.id', 'models.name', 'models.avg_rating', 'models.rating_count', 'models.img_url', 'makes.name as make_name', 'years.number as year')
		->orderBy('models.updated_at', 'DESC')
		->take(10)->get();

		// Get top rated models (current model year on the market) // TODO: This currently selects both previous and last year. Make it so it returns previous or last only.
        $topModels = \DB::table('models')
        ->where('rating_count', '>=', 3)
        ->join('years_makes', 'models.year_make_id', '=', 'years_makes.id')
       	->join('makes', 'makes.id', '=', 'years_makes.make_id')
       	->join('years', 'years_makes.year_id', '=', 'years.id')
       	->whereIn('years.number', self::YEARS)
       	->select('models.id', 'models.name', 'models.avg_rating', 'models.rating_count', 'models.img_url', 'makes.name as make_name', 'years.number as year')
       	->orderBy('models.avg_rating', 'DESC')
       	->take(10)->get();

    	return View::make('home')->withModels($updatedModels)->withTopModels($topModels);
	}

	//////////////////////////////////////////////////////////////////
	//                       Rankings PAGE                          // 
	//////////////////////////////////////////////////////////////////
	protected function showRankings() {
    	return View::make('rankings');
	}

	//////////////////////////////////////////////////////////////////
	//                    Ranking Results PAGE                      // 
	//////////////////////////////////////////////////////////////////
	protected function showRankingsResults() {
    	return View::make('rankingsresults');
	}

	//////////////////////////////////////////////////////////////////
	//                         MODEL PAGE                           // 
	//////////////////////////////////////////////////////////////////
	protected function showModel($year_number, $make_name, $model_name) {

		$model = \DB::table('models')
		->where('models.name', '=', $model_name)
		->join('years_makes', 'years_makes.id', '=', 'models.year_make_id')
		->join('makes', 'makes.id', '=', 'years_makes.make_id')
        ->join('years', 'years.id', '=', 'years_makes.year_id')
        ->where('years.number', '=', $year_number)
        ->where('makes.name', '=', $make_name)
        ->select('models.id', 'models.name', 'models.avg_rating', 'models.rating_count', 'models.msrp', 'models.hp_min', 'models.hp_max', 'models.mpg_city', 'models.mpg_road', 'models.engine_options', 'models.img_url', 'makes.name as make_name', 'years.number as year')
        ->first();

        $reviews = Review::where('model_id', $model->id)->get();

    	return View::make('model')->withModel($model)->withReviews($reviews);
	}
}
