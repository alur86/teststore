<?php

use Illuminate\Http\Request;

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

Route::pattern('id', '[0-9]+');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {

Route::get('/api/products', 'ProductsController@index');
 
Route::get('/api/products/{id}', 'ProductsController@show');
 
Route::post('/api/products','ProductsController@store');
 
Route::put('/api/products/{id}','ProductsController@update');
 
Route::delete('/api/products/{id}', 'ProductsController@destroy');
});