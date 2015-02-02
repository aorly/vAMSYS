<?php namespace vAMSYS\Http\Controllers;

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
	public function frame($airlineIcao)
	{
		require_once(__DIR__.'../../public/frame.php');
	}

}
