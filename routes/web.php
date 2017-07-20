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
    Route::get('about', ['as' => 'pages.about', 'uses' => 'PagesController@about']);
    Route::get('events', ['as' => 'pages.events', 'uses' => 'PagesController@events']);
    Route::group(['middleware' => 'auth'], function(){
        // Routes for team registration
        Route::group(['prefix' => 'events/{event_id}'], function(){
            // Registration routes for single participation events
            // Middleware registrations to check whether the user has or not registered events
            Route::get('register', ['as' => 'pages.register', 'uses' => 'PagesController@register'])->middleware('registrations:single,no');
            Route::get('unregister', ['as' => 'pages.unregister', 'uses' => 'PagesController@unregister'])->middleware('registrations:single,yes');
            // Routes for team participation
            // Middleware registrations to check whether the team has or not registered events            
            Route::group(['middleware' => 'registrations:team,no'], function(){
                Route::get('teams/register', ['as' => 'pages.registerteam', 'uses' => 'PagesController@createTeam']);
                Route::post('teams/register', 'PagesController@registerTeam');  
            });    
            Route::get('teams/{id}/unregister', ['as' => 'pages.unregisterteam', 'uses' => 'PagesController@unregisterTeam'])->middleware('registrations:team,yes');
        });
        Route::get('teams/get_college_mates', 'PagesController@getCollegeMates');
        // Route for the user's dashboard
        Route::get('dashboard', ['as' => 'pages.dashboard', 'uses' => 'PagesController@dashboard']);
        // Route for event confirmation
        Route::get('confirm', ['as' => 'pages.confirm', 'uses' => 'PagesController@confirm'])->middleware('registrations.confirm:no');
        // Route for ticket generation
        Route::group(['middleware' => 'registrations.confirm:yes'], function(){
            Route::get('download-ticket', ['as' => 'pages.ticket.download', 'uses' => 'PagesController@downloadTicket']);
            Route::post('upload-ticket', ['as' => 'pages.ticket.upload', 'uses' => 'PagesController@uploadTicketImage']);
        });        
    });
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
    //CRUD routes for events
    Route::resource('events', 'EventsController', ['except' => 'show']);
});


