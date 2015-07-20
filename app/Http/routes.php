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

// Special cases for smartCARS
Route::group(['domain' => 'smartcars' . env('APP_DOMAIN')], function () {
  Route::any('/{airlineICAO}/frame.php', 'smartCARSController@main');
});

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/flights/cancel/{booking}', 'FlightsController@getCancel');
Route::get('/flights/book/{route}', 'FlightsController@getDoBook');
Route::get('/flights/jumpseat/{route}', 'FlightsController@getDoJumpseat');

Route::get('/pireps/{pirep}', 'PirepsController@getSinglePirep');

Route::get('/staff/pireps/view/{pirep}', 'Staff\PirepsController@getView');
Route::get('/staff/pireps/accept/{pirep}', 'Staff\PirepsController@getAccept');
Route::get('/staff/pireps/reject/{pirep}', 'Staff\PirepsController@getReject');
Route::get('/staff/pireps/reprocess/{pirep}', 'Staff\PirepsController@getReprocess');
Route::get('/staff/pireps/rescore/{pirep}', 'Staff\PirepsController@getRescore');

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::controllers([
    'auth'              => 'Auth\AuthController',
    'password'          => 'Auth\PasswordController',
    'staff/pilots'      => 'Staff\PilotsController',
    'staff/airports'    => 'Staff\AirportsController',
    'staff/routes'      => 'Staff\RoutesController',
    'staff/pireps'      => 'Staff\PirepsController',
    'staff/settings'    => 'Staff\SettingsController',
    'staff'             => 'Staff\StaffController',
    'dashboard'         => 'DashboardController',
    'flights'           => 'FlightsController',
    'pireps'            => 'PirepsController',
    'leaderboards'      => 'LeaderboardsController'
]);
