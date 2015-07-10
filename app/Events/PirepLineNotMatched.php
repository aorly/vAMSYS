<?php namespace vAMSYS\Events;

use vAMSYS\Events\Event;

use Illuminate\Queue\SerializesModels;
use vAMSYS\Pirep;

class PirepLineNotMatched extends Event {

	use SerializesModels;
    /**
     * @var Pirep
     */
    public $pirep;
    /**
     * @var
     */
    public $line;

    /**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(Pirep $pirep, $line, $lineData)
	{
        $this->pirep = $pirep;
        $this->line = $line;
        $this->lineData = $lineData;
    }

}
