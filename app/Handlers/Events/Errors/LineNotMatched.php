<?php namespace vAMSYS\Handlers\Events\Errors;

use Illuminate\Contracts\Queue\ShouldQueue;
use vAMSYS\Events\PirepLineNotMatched;
use vAMSYS\UnparsedLine;

class LineNotMatched implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param PirepLineNotMatched $event
     * @return void
     */
    public function handle(PirepLineNotMatched $event)
    {
        $upl = new UnparsedLine();
        $upl->acars_id = $event->pirep->acars_id;
        $upl->pirep_id = $event->pirep->id;
        $upl->line = $event->lineData;
        $upl->save();
    }

}
