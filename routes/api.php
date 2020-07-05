<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::post('search', 'BusinessListingsController@search');
Route::get('listing/{listing}', 'BusinessListingsController@listing');

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'admin'], function() {
    Route::get('user', function(Request $request){
        return $request->user();
    });

    Route::group(['prefix' => 'categories'], function() {
        Route::post('add', 'CategoriesController@create');
        Route::get('/', 'CategoriesController@fetchCategories');
        Route::get('/all', 'CategoriesController@fetchAllCategories');
        Route::delete('{category}', 'CategoriesController@delete');
        Route::patch('{category}', 'CategoriesController@update');
    });
    Route::group(['prefix' => 'listings'], function() {
        Route::post('add', 'BusinessListingsController@create');
        Route::get('/', 'BusinessListingsController@listings');
        Route::patch('{listing}', 'BusinessListingsController@editListing');
        Route::delete('{listing}', 'BusinessListingsController@delete');
    });
});


