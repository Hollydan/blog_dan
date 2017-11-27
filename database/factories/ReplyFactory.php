<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {

    $time = $faker->dateTimeThisMonth();
    return [
        'content' => $faker->sentences(5, true),
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
