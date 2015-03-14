<?php namespace vAMSYS\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'vAMSYS\Events\PirepWasFiled' => [
			'vAMSYS\Handlers\Events\Pireps\Process',
		],
        'vAMSYS\Events\PirepWasProcessed' => [
            'vAMSYS\Handlers\Events\Pireps\Score',
        ],
        'vAMSYS\Events\PirepWasScored' => [
            'vAMSYS\Handlers\Events\Email\PirepComplete',
        ],
        'vAMSYS\Events\PirepLineNotMatched' => [
            'vAMSYS\Handlers\Events\Email\LineNotMatched',
        ],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);
	}

}
