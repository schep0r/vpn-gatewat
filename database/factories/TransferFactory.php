<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Transfer::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween('-3 month'),
        'resource' => $faker->url,
        'transferred' => $faker->numberBetween(1, 9) * $faker->numberBetween(1, 1000) * 1000 * 1000 * 1000
    ];
});
