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

use Symfony\Component\HttpFoundation\File\File;
use vAMSYS\Airport;
use vAMSYS\Country;
use vAMSYS\Region;

// Special cases for smartCARS
Route::group(['domain' => 'acars.vamsys.io'], function()
{
  Route::any('/{airlineICAO}/smartCARS/frame.php', 'smartCARSController@main');
});

Route::get('/', function () {
  return redirect('/dashboard');
});

Route::get('/flights/cancel/{booking}', 'FlightsController@getCancel');
Route::get('/flights/book/{route}', 'FlightsController@getDoBook');

Route::controllers([
  'auth'      => 'Auth\AuthController',
  'password'  => 'Auth\PasswordController',
  'admin'     => 'Admin\AdminController',
  'staff'     => 'Staff\StaffController',
  'dashboard' => 'DashboardController',
  'flights'   => 'FlightsController'
]);

Route::post('/stripe/webhook', 'Laravel\Cashier\WebhookController@handleWebhook');