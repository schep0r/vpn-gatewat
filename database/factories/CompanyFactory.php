<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'quota' => $faker->numberBetween(1, 10) * 1000000000000,
    ];
});
