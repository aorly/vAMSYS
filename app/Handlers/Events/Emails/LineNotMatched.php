<?php namespace vAMSYS\Handlers\Events\Emails;

use Illuminate\Contracts\Queue\ShouldBeQueued;
use Raygun4php\RaygunClient;
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
        echo "PIREP Process Error: Line ".$event->line." not matched in PIREP ".$event->pirep->id.PHP_EOL;
        echo "Line: ".$event->lineData;
	}

}
