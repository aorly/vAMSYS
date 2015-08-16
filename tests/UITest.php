<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class UITest extends TestCase {

    use DatabaseTransactions;

    /**
     * Basic use of core functionality of vAMSYS.
     *
     * @return void
     */
    public function testLoginWorks()
    {
        $password = str_random();
        $user = $this->createUser($password);
        $airline = $this->createAirline();
        $country = $this->createCountry();
        $region = $this->createRegion($country);
        $airport = $this->createAirport($region);
        $rank = $this->createRank($airline);
        $pilot = $this->createPilot($user, $airline, $rank, $airport);

        // Attempt a login
        $this->visit('/auth/login')
            ->see('Sign In')                        // Can see the Sign In Form
            ->type($pilot->username, '#login')      // Type username
            ->type($password, '#password')          // Type password
            ->press('Login')                        // Try Logging In
            ->see('Dashboard')                      // Login Successful
            ->dontSee('Invalid Credentials')        // Login Not Unsuccessful
            ->dontSee('Staff Centre')               // Can't see Staff Centre
            ->see($user->firstName)                 // Can see first name
            ->click('Book Flight')                  // Go to Book Flight page
            ->see('Book Flight')                    // Reached Book Flight page
            ->click('PIREPs')                       // Go to PIREPs list
            ->see('PIREPs');                        // See PIREPs list page
    }

}
