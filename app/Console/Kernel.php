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
        'vAMSYS\Console\Commands\ImportCountries',
        'vAMSYS\Console\Commands\ImportRegions',
        'vAMSYS\Console\Commands\ImportAirports',
        'vAMSYS\Console\Commands\ParseTextDataCommand'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

    }

}
