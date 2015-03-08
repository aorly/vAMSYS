<?php namespace vAMSYS\Handlers\Events\Emails;

use vAMSYS\Events\PirepWasProcessed;

use Illuminate\Contracts\Queue\ShouldBeQueued;

class PirepProcessed implements ShouldBeQueued {

	/**
	 * Handle the event.
	 *
	 * @param  PirepWasProcessed  $event
	 * @return void
	 */
	public function handle(PirepWasProcessed $event)
	{
		// Email the user
        echo "emailing ".$event->pirep->booking->pilot->user->email.PHP_EOL;
	}

}
