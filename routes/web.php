<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('home');
});

Route::get('fetchData', 'HomeController@fetchData');

Route::resource('user', 'Modules\UserController');
Route::resource('marketplace', 'Modules\MarketPlaceController');
Route::resource('customer', 'Modules\CustomerController');

// User Module
Route::get('{any}','HomeController@index')->where('any', '.*');
