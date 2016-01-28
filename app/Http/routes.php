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

// Password reset
Route::get('password/email', 'Auth\PasswordController@getEmail')->name('auth.password');
Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Social
Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');

// Profile
Route::resource('profile', 'ProfilesController',
               ['except' => ['index']]);
Route::get('profile/{id?}', 'ProfilesController@show')->name('profile.display');
Route::post('profile/upload', 'ProfilesController@upload')->name('profile.upload');

// Settings
Route::get('settings/account', function() {
    return view('settings.account')->with('sidebarView', 1);
})->name('settings.account');
Route::get('settings/notifications', function() {
    return view('settings.notifications')->with('sidebarView', 1);
})->name('settings.notifications');

// TBD
Route::get('/tbd', function() { return view('tbd'); })->name('tbd');
Route::get('/tbds', function() { return view('tbd')->with('sidebarView', 1); })->name('tbds');

// Dashboard
Route::get('/dashboard', function() {
  return view('dashboard')->with('sidebarView', 1);
});

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

// Events
Route::get('events/{filters?}', 'Events\EventsController@index')->name('events');
Route::get('events/new', 'Events\EventsController@newEvent')->name('events.new');
Route::post('events/comment', 'Events\CommentController@save')->name('events.comment');
Route::get('events/edit/{id}', 'Events\EditEventController@index')->name('events.edit');

// Event
Route::get('events/{slug}', 'Events\EventController@index')->name('events.event');
Route::get('events/{slug}/members', 'Events\EventController@members')->name('events.event.members');
Route::get('events/{slug}/followers', 'Events\EventController@followers')->name('events.event.followers');
Route::get('events/{slug}/cancel', 'Events\EventController@cancel')->name('events.event.cancel');
Route::get('events/{slug}/join/{type}', 'Events\EventController@join')->name('events.event.join');
