<?php namespace vAMSYS\Commands;

use vAMSYS\Booking;

use Illuminate\Contracts\Bus\SelfHandling;
use vAMSYS\Contracts\Callsign;

class ProcessBooking extends Command implements SelfHandling {
	/**
	 * @var Booking
	 */
	private $booking;

	/**
	 * Create a new command instance.
	 *
	 * @param Booking $booking
	 */
	public function __construct(Booking $booking)
	{
		$this->booking = $booking;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle(Callsign $callsign)
	{
		// Create the booking callsign
		$callsignRules = $this->booking->route->callsign_rules;
		if ($callsignRules === "") // Use Airline Rules
			$callsignRules = $this->booking->pilot->airline->callsign_rules;

		if ($callsignRules === "") // Revert to Default Rules (PREFIX + 2 DIGITS + 1 ALPHANUMERIC + 1 ALPHA)
			$callsignRules = "[0-9]{2}[A-Z0-9]{1}[A-Z]{1}";

		$this->booking->callsign = $callsign->generate($this->booking->pilot->airline->prefix, $callsignRules);
		$this->booking->save();
	}

}
