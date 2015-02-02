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

Route::get('/', function () {
  return redirect('/dashboard');
});

/*
 * Route Model Binding Routes (Overrides)
 */
Route::get('/flights/cancel/{booking}', 'FlightsController@getCancel');
Route::get('/flights/book/{route}', 'FlightsController@getDoBook');

Route::get('/acars/smartcars/{airlineICAO}/frame.php', function($airlineICAO)
{
  $_GET['airlineICAO'] = $airlineICAO;
  require_once(__DIR__.'/../../public/frame.php');
  die();
});

Route::controllers([
  'auth'      => 'Auth\AuthController',
  'password'  => 'Auth\PasswordController',
  'admin'     => 'Admin\AdminController',
  'staff'     => 'Staff\StaffController',
  'dashboard' => 'DashboardController',
  'flights'   => 'FlightsController'
]);
