<?php namespace vAMSYS\Providers;

use Illuminate\Support\ServiceProvider;
use Stripe;
use vAMSYS\Airline;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		Airline::setStripeKey(env('STRIPE_KEY'));
		Stripe::setApiKey(env('STRIPE_KEY'));

		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'vAMSYS\Services\Registrar'
		);

		$this->app->bind(
			'vAMSYS\Contracts\Route',
			'vAMSYS\Services\Route'
		);

		$this->app->bind(
			'vAMSYS\Contracts\SmartCARS',
			'vAMSYS\Services\SmartCARS'
		);

		$this->app->bind(
			'vAMSYS\Contracts\Callsign',
			'vAMSYS\Services\Callsign'
		);

        $this->app->bind(
            'vAMSYS\Contracts\PirepParser',
            'vAMSYS\Services\PirepParser'
        );
	}

}
