<?php namespace vAMSYS\Handlers\Events\Pireps;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Event;
use vAMSYS\Events\PirepHasFailed;
use vAMSYS\Events\PirepWasFiled;
use vAMSYS\Events\PirepWasProcessed;
use vAMSYS\Events\PirepWasScored;
use vAMSYS\Services\PirepScorer;

class Score implements ShouldQueue {

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

        if (array_key_exists('failed_automatic_scoring', $event->pirep->pirep_data))
            $event->pirep->pirep_data['failed_automatic_scoring'] = false;

        if (array_key_exists('scores', $event->pirep->pirep_data))
            $event->pirep->pirep_data['scores'] = [];

        if (array_key_exists('scoring_errors', $event->pirep->pirep_data))
            $event->pirep->pirep_data['scoring_errors'] = [];

        $event->pirep->save();

        $event->pirep = PirepScorer::score($event->pirep);

        $event->pirep->status = "complete";
        $event->pirep->processed_time = date('Y-m-d H:i:s');

        if (array_key_exists('failed_automatic_scoring', $event->pirep->pirep_data) && $event->pirep->pirep_data['failed_automatic_scoring'] === true){
            $event->pirep->status = "failed";
            Event::fire(new PirepHasFailed($event->pirep));
        }

        $event->pirep->save();

        Event::fire(new PirepWasScored($event->pirep));
	}

}
