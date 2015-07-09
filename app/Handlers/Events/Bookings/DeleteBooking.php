<?php namespace vAMSYS\Handlers\Events\Bookings;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Event;
use vAMSYS\Airport;
use vAMSYS\Booking;
use vAMSYS\Events\PirepLineNotMatched;
use vAMSYS\Events\PirepWasFiled;

use Illuminate\Contracts\Queue\ShouldBeQueued;
use vAMSYS\Events\PirepWasProcessed;
use vAMSYS\Exceptions\UnmatchedPirepLineException;
use vAMSYS\Pilot;

class DeleteBooking implements ShouldBeQueued {

	/**
	 * Handle the event.
	 *
	 * @param  PirepWasFiled  $event
	 * @return void
	 */
	public function handle(PirepWasFiled $event)
	{
        $event->pirep->booking()->delete();
	}

}
