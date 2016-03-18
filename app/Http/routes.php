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

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', function () {
    	if(Auth::guest()) {
    		return redirect()->guest('login');
    	}
    	else {
    		return view('welcome');
	    }
	});

    Route::get('/home', 'HomeController@index');

    Route::group(['prefix' => 'stores'], function() {    
		Route::get('/', 'BranchController@index');
		Route::get('/locator', 'BranchController@locator');
		Route::get('/add', 'BranchController@add');
	});

    /**
     * This contains all api routes, disabled auth first
     */
    Route::group(['prefix' => 'api'], function() {
    	Route::post('stores', 'BranchController@show');
    	Route::post('stores/add', 'BranchController@add');
    });
});
