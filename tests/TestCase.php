<?php

class TestCase extends \Illuminate\Foundation\Testing\TestCase {

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    protected $baseUrl = "http://localhost";

    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    public function createUser($password)
    {
        return factory(vAMSYS\User::class)->create([
            'password' => bcrypt($password),
            'roles' => new \stdClass()
        ]);
    }

    public function createAirline()
    {
        return factory(vAMSYS\Airline::class)->create();
    }

    public function createAirport($region)
    {
        return factory(vAMSYS\Airport::class)->create([
            "region_id" => $region->id
        ]);
    }

    public function createRank($airline)
    {
        return factory(vAMSYS\Rank::class)->create([
            "airline_id" => $airline->id
        ]);
    }
    
    public function createRegion($country)
    {
        return factory(vAMSYS\Region::class)->create([
            "country_id" => $country->id
        ]);
    }

    public function createCountry()
    {
        return factory(vAMSYS\Country::class)->create();
    }

    public function createPilot($user, $airline, $rank, $airport)
    {
        return factory(vAMSYS\Pilot::class)->create([
            'user_id' => $user->id,
            'rank_id' => $rank->id,
            'airline_id' => $airline->id,
            'location_id' => $airport->id
        ]);
    }

}
