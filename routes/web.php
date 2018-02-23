<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::pattern('id', '[0-9]+');

Route::get('/', 'ProductsController@index')->name('home');
Route::post('/order/checkout', 'OrdersController@checkout')->name('checkout');
Route::get('/order/orders', 'OrdersController@orders')->name('orders');
Route::get('/remove/{id}', 'ProductsController@remove')->name('remove');
//Route::post('/store', 'ProductsController@store')->name('store');
Route::post('/order/complete', 'OrdersController@complete')->name('complete');
Route::get('/success', 'OrdersController@success')->name('success');
Route::get('/fail', 'OrdersController@fail')->name('fail');

Route::group(
[
'prefix' => 'master',
'namespace' => 'master',
'middleware' => 'admin'
], function()
{
Route::resource('admin', 'AdminController');
});