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

// Login Routes
Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Continuous Integration Test
Route::get('/ci', function() { return "CI successful."; });

// Verification Route
Route::get('/verify/{token}', 'CommonController@confirmUser');

// Protected Routes
Route::group(['middleware' => ['auth', 'confirm']], function() {
    // Home Section
    Route::get('/', 'HomeController@getIndex');
    Route::post('/notes', 'HomeController@postNotes');
    Route::get('/user', 'HomeController@getUser');
    Route::post('/user/save', 'HomeController@postUser');
    Route::get('/messages', 'HomeController@getMessages');
    Route::get('/messages/new', 'HomeController@newMessage');
    Route::post('/messages/post', 'HomeController@postMessage');
    Route::get('/messages/view/{id}', 'HomeController@viewMessage')->where('id', '[0-9]+');
    Route::get('/messages/delete/{id}', 'HomeController@deleteMessage')->where('id', '[0-9]+');

    // System Section
    Route::get('/users', 'SystemController@getUsers');
    Route::get('/users/new', 'SystemController@newUser');
    Route::post('/users/new/save', 'SystemController@addUser');
    Route::get('/users/edit/{id}', 'SystemController@editUser')->where('id', '[0-9]+');
    Route::post('/users/edit/save', 'SystemController@saveEditedUser');
    Route::get('/users/suspend/{id}', 'SystemController@suspendUser')->where('id', '[0-9]+');
    Route::get('/users/unsuspend/{id}', 'SystemController@unsuspendUser')->where('id', '[0-9]+');
    Route::get('/users/reassign/{id}', 'SystemController@reassignUserView')->where('id', '[0-9]+');
    Route::post('/users/reassign/save', 'SystemController@reassignUserPost');

    Route::get('/logs', 'SystemController@getLogs');
});
