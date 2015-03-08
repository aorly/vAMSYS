<?php namespace vAMSYS\Events;

use vAMSYS\Events\Event;

use Illuminate\Queue\SerializesModels;
use vAMSYS\Pirep;

class PirepWasProcessed extends Event {

	use SerializesModels;
    /**
     * @var Pirep
     */
    public $pirep;

    /**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Pirep $pirep)
	{
        $this->pirep = $pirep;
    }

}
