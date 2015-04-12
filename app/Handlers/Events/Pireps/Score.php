<?php namespace vAMSYS\Handlers\Events\Pireps;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use vAMSYS\Events\PirepWasFiled;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use vAMSYS\Events\PirepWasProcessed;
use vAMSYS\Events\PirepWasScored;
use vAMSYS\Services\PirepScorer;

class Score implements ShouldBeQueued {

	/**
	 * Handle the event.
	 *
	 * @param  PirepWasFiled  $event
	 * @return void
	 */
	public function handle(PirepWasProcessed $event)
	{
        // Score the PIREP!
        $event->pirep->status = "scoring";
        $event->pirep->processed_time = date('Y-m-d H:i:s');
        $event->pirep->save();

        $event->pirep = PirepScorer::score($event->pirep);

        $event->pirep->status = "complete";
        $event->pirep->processed_time = date('Y-m-d H:i:s');
        $event->pirep->save();

        Event::fire(new PirepWasScored($event->pirep));
	}

}
