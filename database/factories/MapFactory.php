<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory - App\Map */
$factory->define(App\Map::class, function (Faker\Generator $faker) {
    return [
        'image' => $faker->image,
        'name' => $faker->name,
        'description' => $faker->sentence
    ];
});
