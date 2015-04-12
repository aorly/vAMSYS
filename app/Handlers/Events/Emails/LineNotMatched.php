<?php namespace vAMSYS\Handlers\Events\Emails;

use Illuminate\Contracts\Queue\ShouldBeQueued;
use vAMSYS\Events\PirepLineNotMatched;
use vAMSYS\Events\PirepWasScored;

class LineNotMatched implements ShouldBeQueued {

	/**
	 * Handle the event.
	 *
	 * @param  PirepWasProcessed  $event
	 * @return void
	 */
	public function handle(PirepLineNotMatched $event)
	{
		// Email the user
        echo "Line Not Matched: ".$event->line.'<br />'.PHP_EOL;
	}

}
