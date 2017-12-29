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

$factory->define(App\PreregisteredUser::class, function (Faker $faker) {
    return [
        'firstName' => $faker->name,
        'lastName'=> $faker->regexify('514[1-9]{7}'),
        'email'=> $faker->unique()->email,
    ];
});
