<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', function(){
        return redirect()->route('appointments.index');
    })->name('home')->middleware(['doctor_or_patient']);

    Route::get('/profiles/{profile}/edit', 'ProfileController@edit')->name('profiles.edit')->middleware('patient');
    Route::put('/profiles/{profile}', 'ProfileController@update')->name('profiles.update')->middleware('patient');


    Route::resource('appointments','AppointmentController')->only(['destroy','create','store'])->middleware('patient');

    Route::group(['middleware'=>['doctor_or_patient']],function(){
        Route::resource('appointments','AppointmentController')->only(['index','show','update','edit']);
        Route::get('/notifications','NotificationController@index')->name('notifications.index');
        Route::get('/notifications/{notification}','NotificationController@show')->name('notifications.show');
    });

    Route::get('/profiles/{profile}', 'ProfileController@show')->name('profiles.show');

    Route::group(['prefix'=>'dashboard','as'=>'dashboard.','namespace'=>'dashboard','middleware'=>['admin']],function(){
        Route::get('/','DashboardController@index')->name('index');
        Route::resource('appointments','AppointmentController')->except(['destroy','create','store']);
        Route::resource('users','UserController');
    });
});

