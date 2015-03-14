<?php namespace vAMSYS\Handlers\Events\Emails;

use Illuminate\Contracts\Queue\ShouldBeQueued;
use vAMSYS\Events\PirepLineNotMatched;
use vAMSYS\Events\PirepWasScored;

class LineNotMotched implements ShouldBeQueued {

	/**
	 * Handle the event.
	 *
	 * @param  PirepWasProcessed  $event
	 * @return void
	 */
	public function handle(PirepLineNotMatched $event)
	{
		// Email the user
        echo "emailing ".$event->pirep->booking->pilot->user->email.PHP_EOL;
	}

}
