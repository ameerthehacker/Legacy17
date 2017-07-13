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

Route::get('/', ['as' => 'root', 'uses' => 'PagesController@events']);
Route::get('/about', ['as' => 'pages.about', 'uses' => 'PagesController@about']);
Route::get('/events', ['as' => 'pages.events', 'uses' => 'PagesController@events']);

// Authentication routes
Route::get('/auth/register', ['as'=>'auth.register', 'uses'=>'Auth\RegisterController@showRegistrationForm']);
Route::post('/auth/register', 'Auth\RegisterController@register');
