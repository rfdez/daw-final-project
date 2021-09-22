<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'latitude' => $faker->latitude($min = 36.0105556, $max = 43.7902778),
        'longitude' => $faker->longitude($min = -9.301388888888889, $max = 3.322222222222222),
        'altitude' => $faker->numberBetween($min = 10, $max = 965),
        'speed' => 0
    ];
});
