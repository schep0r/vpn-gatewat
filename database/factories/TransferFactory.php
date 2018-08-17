<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Transfer::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween('-6 month'),
        'resource' => $faker->url,
        'transferred' => $faker->numberBetween(100, 10000000000000000)
    ];
});
