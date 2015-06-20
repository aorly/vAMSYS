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

// Admin routes
Route::group(['domain' => 'admin' . env('APP_DOMAIN')], function () {
  Route::controller('/', 'Admin\AdminController');
});

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/flights/cancel/{booking}', 'FlightsController@getCancel');
Route::get('/flights/book/{route}', 'FlightsController@getDoBook');

Route::get('/pireps/{pirep}', 'PirepsController@getSinglePirep');

Route::controllers([
    'auth'           => 'Auth\AuthController',
    'password'       => 'Auth\PasswordController',
    'staff/pilots'   => 'Staff\PilotsController',
    'staff/airports' => 'Staff\AirportsController',
    'staff/routes'   => 'Staff\RoutesController',
    'staff'          => 'Staff\StaffController',
    'dashboard'      => 'DashboardController',
    'flights'        => 'FlightsController',
    'pireps'         => 'PirepsController'
]);
