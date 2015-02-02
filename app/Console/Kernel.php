<?php namespace vAMSYS\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'vAMSYS\Console\Commands\Inspire',
		'vAMSYS\Console\Commands\ImportCountriesCommand',
		'vAMSYS\Console\Commands\ImportRegionsCommand',
		'vAMSYS\Console\Commands\ImportAirportsCommand'
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('inspire')
				 ->hourly();
	}

}
