<?php namespace vAMSYS\Events;

use Illuminate\Queue\SerializesModels;
use vAMSYS\Pilot;
use vAMSYS\Pirep;

class PirepWasFiled extends Event {

	use SerializesModels;

    public $pirep;
    public $pilot;

    /**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Pirep $pirep, Pilot $pilot)
	{
		$this->pirep = $pirep;
        $this->pilot = $pilot;
    }

}
