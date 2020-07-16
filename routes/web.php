<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profiles/{profile}/edit', 'ProfileController@edit')->name('profiles.edit');
    Route::put('/profiles/{profile}', 'ProfileController@update')->name('profiles.update');
    Route::get('/profiles/{profile}', 'ProfileController@show')->name('profiles.show');
    Route::resource('appointments','AppointmentController')->except(['show']);
});

