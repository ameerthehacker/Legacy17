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

Route::group(['middleware' => 'auth.redirect_admin'], function(){
    Route::get('/', ['as' => 'pages.root', 'uses' => 'PagesController@events']);
    Route::get('/about', ['as' => 'pages.about', 'uses' => 'PagesController@about']);
    Route::get('/events', ['as' => 'pages.events', 'uses' => 'PagesController@events']);
});

// Authentication routes
Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function(){
    // Login routes
    Route::get('login', ['as' => 'auth.login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('login', 'LoginController@login');
    // Logout route
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'LoginController@logout']);
    // Registration routes
    Route::get('register', ['as' => 'auth.register', 'uses' => 'RegisterController@showRegistrationForm']);
    Route::post('register', 'RegisterController@register');
});

// Routes for administrators
Route::group(['prefix' => 'admin', 'as' => 'admin::', 'middleware' => ['auth','auth.admin']], function(){
    Route::get('/', ['as' => 'root', 'uses' => function(){
        echo 'Root';
    }]);
    Route::get('events', function(){
        echo 'Admin route';
    });
});


