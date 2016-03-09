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
Route::get('auth/social/{provider}', 'Auth\AuthController@redirectToProvider')->name('social.redirect');
Route::get('auth/social/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('social.handle');

// Profile
Route::get('profile', 'ProfilesController@show')->name('profile.my');
Route::post('profile/upload', 'ProfilesController@upload')->name('profile.upload');
Route::get('profile/time-line', 'ProfilesController@timeLine')->name('profile.timeline');
Route::get('profile/{id}/edit', 'ProfilesController@edit')->name('profile.edit')->where('id', '[0-9]+');
Route::patch('profile/{id}/update', 'ProfilesController@update')->name('profile.update')->where('id', '[0-9]+');
Route::get('profile/{id?}', 'ProfilesController@show')->name('profile.display')->where('id', '[0-9]+');

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
Route::get('mail', ['middleware' => 'auth', 'uses' => 'Mail\ConversationsController@conversationsList'])->name('mail');
Route::get('mail/l/{label}', ['middleware' => 'auth', 'uses' => 'Mail\ConversationsController@conversationsList'])->name('mail.label');
Route::get('mail/move/{id}/{label}', ['middleware' => 'auth', 'uses' => 'Mail\ConversationsController@moveToLabel'])->name('mail.move');
Route::get('mail/{id}', ['middleware' => 'auth', 'uses' => 'Mail\MessagesController@showConversation'])->name('mail.conversation')->where('id', '[0-9]+');
Route::get('mail/new/{user_id}', ['middleware' => 'auth', 'uses' => 'Mail\MessagesController@newMessageForm'])->name('mail.new.form')->where('user_id', '[0-9]+');
Route::post('mail/new', ['middleware' => 'auth', 'uses' => 'Mail\MessagesController@newMessage'])->name('mail.new');
Route::get('mail/important/{id}/{is_important}', ['middleware' => 'auth', 'uses' => 'Mail\ConversationsController@important'])->name('mail.important');

// Notifications
Route::get('notifications', ['middleware' => 'auth', 'uses' => 'Notifications\NotificationsController@index'])->name('notifications');
Route::get('notifications/{id}', ['middleware' => 'auth', 'uses' => 'Notifications\NotificationsController@callback'])->name('notifications.callback')->where('id', '[0-9]+');;
Route::get('notifications/get', ['middleware' => 'auth', 'uses' => 'Notifications\NotificationsController@getNotifications'])->name('notifications.get');

// Events
Route::match(['get', 'post'], 'search/{filters?}', ['middleware' => 'auth', 'uses' => 'Events\EventsController@index'])->name('events');
Route::get('events/new', ['middleware' => 'auth', 'uses' => 'Events\EventsController@newEvent'])->name('events.new');
Route::post('events/comment', ['middleware' => 'auth', 'uses' => 'Events\CommentController@save'])->name('events.comment');
Route::match(['get', 'post'], 'events/edit/{id}', ['middleware' => 'auth', 'uses' => 'Events\EditEventController@index'])->name('events.edit');
Route::get('events/edit/{id}/members', ['middleware' => 'auth', 'uses' => 'Events\EditEventController@members'])->name('events.edit.members');
Route::match(['get', 'post'], 'events/edit/{id}/photo', ['middleware' => 'auth', 'uses' => 'Events\EditEventController@photo'])->name('events.edit.photo');
Route::get('events/edit/{id}/{user_id}/{status}', ['middleware' => 'auth', 'uses' => 'Events\EditEventController@status'])->name('events.edit.members.status');

// Event
Route::get('events/{slug}', 'Events\EventController@index')->name('events.event');
Route::get('events/{slug}/members', 'Events\EventController@members')->name('events.event.members');
Route::get('events/{slug}/followers', 'Events\EventController@followers')->name('events.event.followers');
Route::get('events/{slug}/cancel', ['middleware' => 'auth', 'uses' => 'Events\EventController@cancel'])->name('events.event.cancel');
Route::get('events/{slug}/join/{type}', ['middleware' => 'auth', 'uses' => 'Events\EventController@join'])->name('events.event.join');
Route::get('events/{slug}/resign', ['middleware' => 'auth', 'uses' => 'Events\EventController@resign'])->name('events.event.resign');
Route::get('events/{slug}/share', 'Events\EventController@share')->name('events.event.share');

/**
 * Set true if you want debug all queries
 */
if(false) {
    Event::listen('illuminate.query',function($query){
        var_dump($query);
    });
}