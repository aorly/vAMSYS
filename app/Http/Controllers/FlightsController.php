<?php namespace vAMSYS\Http\Controllers;

use vAMSYS\Booking;
use vAMSYS\Repositories\PilotRepository;
use vAMSYS\Route;

class FlightsController extends Controller {

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
	public function getIndex()
	{
		if (PilotRepository::countBookedFlights() == 0)
			return view('flights.book');
		return view('flights.home');
	}

	public function getCancel(Booking $booking)
	{
		$pilot = PilotRepository::getCurrentPilot();
		if ($booking->pilot->id != $pilot->id)
			return redirect('/flights');

		$booking->delete();
		return redirect('/flights');
	}

	public function getBook()
	{
		return view('flights.book');
	}

	public function getDoBook(Route $route)
	{
		// todo: VALIDATE!
		$booking = new Booking();
		$booking->pilot()->associate(PilotRepository::getCurrentPilot());
		$booking->route()->associate($route);
		$booking->aircraft_id = 1; // todo select aircraft
		$booking->save();
		return redirect('/flights');
	}

}
