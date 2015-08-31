<?php namespace vAMSYS\Http\Controllers;

use vAMSYS\Airline;
use vAMSYS\Booking;
use vAMSYS\Commands\ProcessBooking;
use vAMSYS\Contracts\Callsign;
use vAMSYS\Pirep;
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

        $bookings = $pilot->bookings()->where('id', '>=', $booking->id)->get();

        foreach($bookings as $booking)
            $booking->delete();

        return redirect('/flights');
    }

    public function getBook()
    {
        return view('flights.book');
    }
    public function getJumpseat()
    {
        return view('flights.jumpseat');
    }

    public function getDoBook(Callsign $callsign, Route $route)
    {
        // todo: VALIDATE!
        $booking = new Booking();
        $booking->pilot()->associate(PilotRepository::getCurrentPilot());
        $booking->route()->associate($route);
        $booking->aircraft_id = 1; // todo select aircraft

        $callsignRules = $booking->route->callsign_rules;
        if ($callsignRules === NULL) // Use Airline Rules
            $callsignRules = $booking->pilot->airline->callsign_rules;

        if ($callsignRules === NULL) // Revert to Default Rules (PREFIX + 2 DIGITS + 1 ALPHANUMERIC + 1 ALPHA)
            $callsignRules = "[0-9]{2}[A-Z0-9]{1}[A-Z]{1}";

        $booking->callsign = $callsign->generate($booking->pilot->airline->prefix, $callsignRules);
        $booking->save();

        return redirect('/flights');
    }

    public function getDoJumpseat(Route $route)
    {
        // todo: VALIDATE!

        $pilot = PilotRepository::getCurrentPilot();

        // Save this jumpseat so we can track them!
        $booking = new Booking();
        $booking->pilot()->associate($pilot);
        $booking->route()->associate($route);
        $booking->aircraft_id = null; // This indicates a jumpseat booking
        $booking->callsign = 'JUMPSEAT'; // This also indicates a jumpseat booking
        $booking->save();
        $booking->delete();

        // Put in a dummy PIREP
        $pirep = new Pirep();
        $pirep->booking()->associate($booking);
        $pirep->pirep_data = ['jumpseat' => true];
        $pirep->status = 'complete';
        $pirep->points = 0;
        $pirep->landing_rate = 0;
        $pirep->fuel_used = 0;
        $pirep->load = 0;
        $pirep->save();

        $pilot->location()->associate($route->arrivalAirport);
        $pilot->save();

        return redirect('/flights');
    }

}
