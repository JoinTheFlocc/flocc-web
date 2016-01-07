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
Route::get('auth/login', 'Auth\AuthController@getLogin')->name('auth.login');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout')->name('auth.logout');

// Registration
Route::get('auth/register', 'Auth\AuthController@getRegister')->name('auth.register');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/postregister', function() { return view('auth/postregister'); });
Route::get('auth/verify/{code}', 'Auth\AuthController@verifyEmail');
Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');

// Password reset - TEMP
Route::get('password/email', function() { return view('tbd'); });

// Profile
Route::resource('profile', 'ProfilesController');
Route::get('profile/{id}', 'ProfileController@show')->name('profile.display')->where('id', '[0-9]+');
//Route::get('profile/create', 'ProfilesController@create');
//Route::post('profile', 'ProfilesController@store');

// TBD
Route::get('/tbd', function() { return view('tbd'); });

// Mail
Route::get('mail', 'Mail\ConversationsController@conversationsList')->name('mail');
Route::get('mail/l/{label}', 'Mail\ConversationsController@conversationsList')->name('mail.label');
Route::get('mail/move/{id}/{label}', 'Mail\ConversationsController@moveToLabel')->name('mail.move');
Route::get('mail/{id}', 'Mail\MessagesController@showConversation')->name('mail.conversation')->where('id', '[0-9]+');
Route::get('mail/new/{user_id}', 'Mail\MessagesController@newMessageForm')->name('mail.new.form')->where('user_id', '[0-9]+');
Route::post('mail/new', 'Mail\MessagesController@newMessage')->name('mail.new');

// Notifications
Route::get('notifications', 'Notifications\NotificationsController@index')->name('notifications');
Route::get('notifications/{id}', 'Notifications\NotificationsController@callback')->name('notifications.callback')->where('id', '[0-9]+');;
Route::get('notifications/get', 'Notifications\NotificationsController@getNotifications')->name('notifications.get');