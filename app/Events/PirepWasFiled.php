<?php namespace vAMSYS\Events;

use Illuminate\Queue\SerializesModels;
use vAMSYS\Pilot;
use vAMSYS\Pirep;

class PirepWasFiled extends Event {

	use SerializesModels;

    public $pirep;
    public $pilot;
    public $reProcess;

    /**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Pirep $pirep, Pilot $pilot, $reProcess = false)
	{
		$this->pirep = $pirep;
        $this->pilot = $pilot;
        $this->reProcess = $reProcess;
    }

}
