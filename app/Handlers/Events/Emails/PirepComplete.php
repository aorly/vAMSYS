<?php namespace vAMSYS\Handlers\Events\Emails;

use Illuminate\Contracts\Queue\ShouldBeQueued;
use vAMSYS\Events\PirepWasScored;

class PirepComplete implements ShouldBeQueued {

	/**
	 * Handle the event.
	 *
	 * @param  PirepWasProcessed  $event
	 * @return void
	 */
	public function handle(PirepWasScored $event)
	{
		// Email the user
        echo "emailing ".$event->pirep->booking->pilot->user->email.PHP_EOL;
	}

}
