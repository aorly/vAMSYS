<?php namespace vAMSYS\Handlers\Events\Emails;

use Illuminate\Contracts\Queue\ShouldBeQueued;
use Raygun4php\RaygunClient;
use vAMSYS\Events\PirepHasFailed;
use vAMSYS\Events\PirepLineNotMatched;
use vAMSYS\Events\PirepWasScored;

class PirepFailed implements ShouldBeQueued {

	/**
	 * Handle the event.
	 *
	 * @param  PirepFailed  $event
	 * @return void
	 */
	public function handle(PirepHasFailed $event)
	{
        // TODO: More...
        echo "PIREP Failed: ".$event->pirep->id.PHP_EOL;
	}

}
