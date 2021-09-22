<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Value;
use Faker\Generator as Faker;

$factory->define(Value::class, function (Faker $faker) {
    return [
        'temperature' => $faker->numberBetween($min = 0, $max = 47),
        'humidity' => $faker->numberBetween($min = 0, $max = 100),
    ];
});
