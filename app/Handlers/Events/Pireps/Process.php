<?php namespace vAMSYS\Handlers\Events\Pireps;

use Illuminate\Support\Facades\Event;
use vAMSYS\Events\PirepWasFiled;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use vAMSYS\Events\PirepWasProcessed;

class Process implements ShouldBeQueued {

	/**
	 * Handle the event.
	 *
	 * @param  PirepWasFiled  $event
	 * @return void
	 */
	public function handle(PirepWasFiled $event)
	{
		echo "processing pirep ".$event->pirep->id.PHP_EOL;
        // Actually Process the PIREP...

        $event->pirep->status = "processed";
        $event->pirep->processed_time = date('Y-m-d H:i:s');
        $event->pirep->save();
        Event::fire(new PirepWasProcessed($event->pirep));
	}

}
