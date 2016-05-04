<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'PageController@showHome');
    Route::get('rankings', 'PageController@showRankings');
    Route::get('rankings/results', 'PageController@showRankingsResults');
    Route::get('model/{year}/{make}/{model}', 'PageController@showModel');

    // Admin routes

    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');

    Route::get('admin', 'AdminController@showAdmin');

    Route::get('admin/years', 'AdminController@showAllYears');
    Route::post('admin/addyear', 'AdminController@addYear');
    Route::post('admin/deleteyear', 'AdminController@deleteYear');

    Route::get('admin/makes', 'AdminController@showAllMakes');
    Route::post('admin/addmake', 'AdminController@addMake');
    Route::post('admin/deletemake', 'AdminController@deleteMake');
    
    Route::get('admin/models', 'AdminController@showAllModels');
    Route::post('admin/addmodel', 'AdminController@addModel');
    Route::post('admin/deletemodel', 'AdminController@deleteModel');

    Route::get('admin/models/{id}/reviews', 'AdminController@showModelReviews');
    Route::post('admin/models/{id}/addreview', 'AdminController@addModelReview');
    Route::post('admin/models/{id}/deletereview/{review}', 'AdminController@deleteModelReview');
    Route::get('admin/models/{id}/editreview/{review}', 'AdminController@viewModelReview');
    Route::post('admin/models/{id}/editreview/{review}', 'AdminController@editModelReview');

    Route::get('admin/models/{id}', 'AdminController@showModel');
    Route::post('admin/models/{id}', 'AdminController@editModel');
});
