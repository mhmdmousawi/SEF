<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'profile_id' => rand(1,2),
        'full_name' => str_random(10),
        'display_name' => str_random(10),
        'status' => str_random(20),
        'phone' => rand(7,8)
    ];
});

$factory->define(App\Channel::class, function (Faker $faker) {
    return [
        'name' => "Test Channel",
        'purpose' => str_random(10),
        'creator_id' =>rand(1,2)
    ];
});
