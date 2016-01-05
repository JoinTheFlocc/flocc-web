<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/postregister', function() {
    return view('auth/postregister');
});

// Password reset - TEMP
Route::get('password/email', function() {
    return view('tbd');
});

Route::get('auth/verify/{code}', 'Auth\AuthController@verifyEmail');

Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');

Route::resource('profile', 'ProfilesController');
//Route::get('profile/{id}', 'ProfileController@show');
//Route::get('profile/create', 'ProfilesController@create');
//Route::post('profile', 'ProfilesController@store');

// User
//Route::get('user', 'UserController');
//Route::get('user/{id}', 'UserController@showProfile');
//Route::get('mail/{id}', array( 'uses' => 'UserController@sendEmail'));

Route::get('/tbd', function() {
    return view('tbd');
});
