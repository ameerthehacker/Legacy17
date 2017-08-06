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
    Route::get('/', ['as' => 'pages.root', 'uses' => 'PagesController@root'])->middleware('guest');
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
        // Route for requesting hospitality
        Route::get('hospitality', ['as' => 'pages.hospitality', 'uses' => 'PagesController@hospitality']);
        Route::get('hospitality/request', ['as' => 'pages.hospitality.request', 'uses' => 'PagesController@requestHospitality']);
        // Route for event confirmation
        Route::get('confirm', ['as' => 'pages.confirm', 'uses' => 'PagesController@confirm'])->middleware('registrations.confirm:no');
        // Route for ticket generation
        Route::group(['middleware' => 'registrations.confirm:yes'], function(){
            Route::get('download-ticket', ['as' => 'pages.ticket.download', 'uses' => 'PagesController@downloadTicket']);
            Route::post('upload-ticket', ['as' => 'pages.ticket.upload', 'uses' => 'PagesController@uploadTicketImage']);
        });  
        Route::get('/payment/reciept', ['as' => 'pages.payment.reciept', 'uses' => 'PagesController@paymentReciept']);        
    });
});

// Payment routes and wont be using csrf
Route::group(['middleware' => 'payment.check'], function(){
    Route::post('/payment/success', ['as' => 'pages.payment.success', 'uses' => 'PagesController@paymentSuccess']);
    Route::post('/payment/failure', ['as' => 'pages.payment.failure', 'uses' => 'PagesController@paymentFailure']);
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
    Route::get('activate', ['as' => 'auth.activate', 'uses' => 'RegisterController@activate']);
    Route::get('change-password', ['as' => 'auth.changePassword', 'uses' => 'PasswordController@showChangePassword']);
    Route::post('change-password', ['uses' => 'PasswordController@changePassword']);
});

// Routes for administrators
Route::group(['prefix' => 'admin', 'as' => 'admin::', 'middleware' => ['auth','auth.admin:']], function(){
    Route::group(['middleware' => 'auth.admin:root'], function(){
        Route::get('registrations', ['as' => 'registrations', 'uses' => 'AdminPagesController@registrations']);
        Route::get('registrations/{user_id}', ['as' => 'registrations.edit', 'uses' => 'AdminPagesController@editRegistration']);

        Route::get('registrations/{user_id}/confirm', ['as' => 'registrations.confirm', 'uses' => 'AdminPagesController@confirmRegistration']); 
        Route::get('registrations/{user_id}/unconfirm', ['as' => 'registrations.unconfirm', 'uses' => 'AdminPagesController@unconfirmRegistration']); 

        Route::get('registrations/{user_id}/payments/confirm', ['as' => 'registrations.payments.confirm', 'uses' => 'AdminPagesController@confirmPayment']); 
        Route::get('registrations/{user_id}/payments/unconfirm', ['as' => 'registrations.payments.unconfirm', 'uses' => 'AdminPagesController@unconfirmPayment']); 

        Route::get('requests/all', ['as' => 'requests.all', 'uses' => 'AdminPagesController@allRequests']);
        Route::get('requests', ['as' => 'requests', 'uses' => 'AdminPagesController@requests']);
        Route::post('requests', 'AdminPagesController@replyRequest');    


    });
    Route::group(['middleware' => 'auth.admin:hospitality'], function(){
        Route::get('accomodations', ['as' => 'accomodations', 'uses' => 'AdminPagesController@accomodationRequests']);
        Route::get('accomodations/all', ['as' => 'accomodations.all', 'uses' => 'AdminPagesController@allAccomodationRequests']);
        Route::post('accomodations', 'AdminPagesController@replyAccomodationRequest');        
    });
    Route::get('/', ['as' => 'root', 'uses' => 'AdminPagesController@root']);
    //CRUD routes for events
    Route::resource('events', 'EventsController', ['except' => 'show']);
});


