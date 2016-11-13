<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/getorder/orderId/{id}', 'OrderController@getOrder')->name('getOrder');
Route::get('/cancelorder/orderId/{id}', 'OrderController@cancelOrder')->name('cancelOrder');

