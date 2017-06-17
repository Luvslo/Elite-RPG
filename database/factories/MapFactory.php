<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory - App\Map */
$factory->define(App\Map::class, function (Faker\Generator $faker) {
    return [
        'image' => $faker->image,
        'name' => $faker->name,
        'description' => $faker->sentence
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory - App\Mov */
$factory->define(App\Mob::class, function (Faker\Generator $faker) {

    return [
        'map_id' => $faker->randomDigit,
        'name' => $faker->name,
        'image' => $faker->image,
        'type' => 'mob',
        'x' => 150,
        'y' => 150,
    ];
});
