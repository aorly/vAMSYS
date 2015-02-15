<?php namespace vAMSYS\Http\Controllers;

use vAMSYS\Airline;

class DashboardController extends Controller {

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex(Airline $airline)
	{
		return view('dashboard');
	}

}
