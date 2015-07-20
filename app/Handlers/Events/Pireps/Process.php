<?php namespace vAMSYS\Handlers\Events\Pireps;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Event;
use vAMSYS\Events\PirepLineNotMatched;
use vAMSYS\Events\PirepWasFiled;
use vAMSYS\Events\PirepWasProcessed;
use vAMSYS\Exceptions\UnmatchedPirepLineException;

class Process implements ShouldQueue {

	/**
	 * Handle the event.
	 *
	 * @param  PirepWasFiled  $event
	 * @return void
	 */
	public function handle(PirepWasFiled $event)
	{
        if (is_array($event->pirep->pirep_data) &&  $event->pirep->pirep_data['jumpseat']){
            return true; // This is a jumpseat!
        }

        $event->pirep->status = "processing";
        $event->pirep->processed_time = date('Y-m-d H:i:s');
        $event->pirep->save();

        $event->pirep->pirep_data = [];

        preg_match('/smartCARS version ([0-9\.]+), ([0-9]+)[\/\.\-]([0-9]+)[\/\.\-]([0-9]+) ([^\[]+)/', $event->pirep->log, $logMeta);
        // Check for UTC+X timezone! Convert to Etc/GMT+X
        if (preg_match("/UTC(\+|-)([0-9]{1,2})/", $logMeta[5], $matches)){
          $logMeta[5] = 'Etc/GMT'.$matches[1].$matches[2];
        }

        $pirepDate = Carbon::createFromDate($logMeta[2], $logMeta[3], $logMeta[4], $logMeta[5]);
        preg_match_all('/\[([0-9:]+ ?[APi]?\.?[nM]?\.?)\] ?([^\[]+)/', $event->pirep->log, $log);
        $currentTime = 0;

        // $log contains arrays of log lines.
        // [0] is full lines
        // [1] is timestamps
        // [2] is parsable lines

        // Format timestamps appropriately
        foreach ($log[1] as &$time) {
            $timeBits = explode(':', $time);
            if ($timeBits[0] < $currentTime){
                $pirepDate = $pirepDate->addDay();
            }
            $time = $pirepDate->toDateString().' '.$time;
            $currentTime = $timeBits[0];
        }

        // Set PIREP times
        $event->pirep->pirep_start_time = new Carbon($log[1][0], $logMeta[5]);
        $event->pirep->pirep_end_time = new Carbon($log[1][count($log[1])-1], $logMeta[5]);

        // Start line parsing
        $pirepParser = new \vAMSYS\Services\PirepParser($event->pirep->acars_id);

        foreach ($log[2] as $lineNumber => $lineData) {
            try {
                $event->pirep = $pirepParser->parseLine(new Carbon($log[1][$lineNumber], $logMeta[5]), $lineData, $event->pirep);
            } catch (UnmatchedPirepLineException $e) {
                Event::fire(new PirepLineNotMatched($event->pirep, $log[1][$lineNumber], $lineData));
            } catch (\Exception $e) {
                // TODO For now, rethrow...
                throw $e;
            }
        }

        // Do we have any unfilled times?
        if ($event->pirep->departure_time == "0000-00-00 00:00:00")
            throw new Exception('PIREP has no departure time'); // todo Replace with better exception

        if ($event->pirep->landing_time == "0000-00-00 00:00:00")
            throw new Exception('PIREP has no landing time'); // todo Replace with better exception

        if ($event->pirep->off_blocks_time == "0000-00-00 00:00:00")
            $event->pirep->off_blocks_time = $event->pirep->departure_time;

        if ($event->pirep->on_blocks_time == "0000-00-00 00:00:00")
            $event->pirep->on_blocks_time = $event->pirep->landing_time;


        $event->pirep->status = "processed";
        $event->pirep->processed_time = date('Y-m-d H:i:s');
        $event->pirep->save();

        Event::fire(new PirepWasProcessed($event->pirep, $event->reProcess));
	}

}
