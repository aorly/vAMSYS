<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(vAMSYS\User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password())
    ];
});

$factory->define(vAMSYS\Pilot::class, function (Faker\Generator $faker) {
    return [
        'username' => strtoupper($faker->bothify('???####'))
    ];
});

$factory->define(vAMSYS\Airline::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'prefix' => strtoupper($faker->lexify('???')),
        'description' => $faker->catchPhrase,
        'url' => $faker->url,
        'scoring_rules' => '{}'
    ];
});

$factory->define(vAMSYS\Airport::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'icao' => strtoupper($faker->lexify('????')),
        'iata' => strtoupper($faker->lexify('???')),
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude
    ];
});

$factory->define(vAMSYS\Rank::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'level' => $faker->randomDigitNotNull
    ];
});

$factory->define(vAMSYS\Region::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->state,
        'code' => $faker->stateAbbr
    ];
});

$factory->define(vAMSYS\Country::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->country,
        'code' => $faker->countryCode,
        'continent' => $faker->randomElement(['EU','AF', 'NA', 'SA', 'AN','AS','OC'])
    ];
});