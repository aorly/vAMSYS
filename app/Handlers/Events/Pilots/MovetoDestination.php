<?php namespace vAMSYS\Handlers\Events\Pilots;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Event;
use vAMSYS\Airport;
use vAMSYS\Events\PirepLineNotMatched;
use vAMSYS\Events\PirepWasFiled;

use Illuminate\Contracts\Queue\ShouldBeQueued;
use vAMSYS\Events\PirepWasProcessed;
use vAMSYS\Exceptions\UnmatchedPirepLineException;
use vAMSYS\Pilot;

class MoveToDestination implements ShouldBeQueued {

	/**
	 * Handle the event.
	 *
	 * @param  PirepWasFiled  $event
	 * @return void
	 */
	public function handle(PirepWasFiled $event)
	{
		if ($event->reProcess === false) {
			// Move the Pilot to their destination field
			$pilot = Pilot::find($event->pirep->booking->pilot->id);
			$newLocation = Airport::find($event->pirep->booking->route->arrivalAirport->id);
			$pilot->location()->associate($newLocation);
			$pilot->save();
			echo "Moved Pilot ID " . $pilot->id . " to Airport " . $newLocation->icao . PHP_EOL;
		}
	}

}
