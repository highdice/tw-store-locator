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
    		return redirect('dashboard');
	    }
	});

    Route::get('/dashboard', 'HomeController@index');

    Route::group(['prefix' => 'users'], function() {    
		Route::get('/', 'UserController@index');
		Route::get('/add', 'UserController@add');
		Route::get('/{id}/edit', 'UserController@edit');
		Route::get('/{id}/status', 'UserController@status');
	});

    Route::group(['prefix' => 'stores'], function() {    
		Route::get('/', 'BranchController@index');
		Route::get('/locator', 'BranchController@locator');
		Route::get('/add', 'BranchController@add');
		Route::get('/{id}/edit', 'BranchController@edit');
		Route::get('/{id}/status', 'BranchController@status');

		Route::group(['prefix' => '/{branch_id}/satellite'], function() { 
			Route::get('/', 'SatelliteController@index');
			Route::get('/add', 'SatelliteController@add');
			Route::get('/{id}/edit', 'SatelliteController@edit');
		});
	});

    /**
     * This contains all api routes, disabled auth first
     */
    Route::group(['prefix' => 'api/v1'], function() {
    	Route::post('stores', 'BranchController@showAll');
    	Route::post('stores/add', 'BranchController@postAdd');
    	Route::post('stores/edit', 'BranchController@postEdit');
    	Route::get('stores/island_groups/{id}', 'BranchController@getStoresByIslandGroup');
        Route::get('stores/island_groups', 'LookupController@getIslandGroups');

        Route::get('stores/regions/{id}', 'BranchController@getStoresByRegion');
        Route::get('stores/regions', 'LookupController@getRegions'); 

        Route::get('stores/branch/date_opened', 'BranchController@getBranchByDateOpened');
        Route::get('stores/branch/{id}', 'BranchController@getBranch');
        Route::get('stores/branch', 'BranchController@getBranches');

        Route::get('stores/divisions', 'LookupController@getDivisions');

        Route::get('stores/satellite/date_opened', 'SatelliteController@getSatelliteByDateOpened');
        Route::get('stores/satellite/{id}', 'BranchController@getSatellite');
        Route::get('stores/satellite', 'BranchController@getSatellites');

    	Route::post('satellite/add', 'SatelliteController@postAdd');
    	Route::post('satellite/edit', 'SatelliteController@postEdit');

    	Route::post('users/add', 'UserController@postAdd');
    	Route::post('users/edit', 'UserController@postEdit');
    });
});
