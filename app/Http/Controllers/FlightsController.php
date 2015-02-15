<?php namespace vAMSYS\Http\Controllers;

use vAMSYS\Airline;
use vAMSYS\Booking;
use vAMSYS\Commands\ProcessBooking;
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
	public function getIndex(Airline $airline)
	{
		if (PilotRepository::countBookedFlights() == 0)
			return view('flights.book');
		return view('flights.home');
	}

	public function getCancel(Airline $airline, Booking $booking)
	{
		$pilot = PilotRepository::getCurrentPilot();
		if ($booking->pilot->id != $pilot->id)
			return redirect('/flights');

		$booking->delete();
		return redirect('/flights');
	}

	public function getBook(Airline $airline)
	{
		return view('flights.book');
	}

	public function getDoBook(Airline $airline, Route $route)
	{
		// todo: VALIDATE!
		$booking = new Booking();
		$booking->pilot()->associate(PilotRepository::getCurrentPilot());
		$booking->route()->associate($route);
		$booking->aircraft_id = 1; // todo select aircraft
		$booking->save();

		$this->dispatch(
			new ProcessBooking($booking)
		);

		return redirect('/flights');
	}

}
