<?php

use Carbon\Carbon;

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

/** @var \Illuminate\Database\Eloquent\Factory $factory - App\User */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


/** @var \Illuminate\Database\Eloquent\Factory $factory - App\Message */
$factory->define(App\Message::class, function (Faker\Generator $faker) {

    return [
        'message' => $faker->sentence,
        'user_id' => App\User::all()->random()->id,
        'created_at' => Carbon::now()
    ];
});
