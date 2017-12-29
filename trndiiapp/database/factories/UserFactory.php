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
    static $password;

    return [
        'name' => $faker->name,
        'phone'=> $faker->regexify('514[1-9]{7}'),
        'addressline1'=> $faker->address,
        'postalcode'=>$faker->regexify('H[0-9]{1}[A-Z]{1} [0-9]{1}[A-Z]{1}[0-9]{1}'),
        'city'=>$faker->city,
        'country'=>$faker->country,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
