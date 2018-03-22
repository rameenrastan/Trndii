<?php

use App\item;
use App\User;
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

$factory->define(App\Transaction::class, function (Faker $faker) {
    $random_user = User::findOrFail($faker->numberBetween(1, 20))->email;
    $random_item = item::findOrFail($faker->unique()->numberBetween(1, 50))->id;

    return [
        'email'=> $random_user,
        'item_fk'=> $random_item,
        'charge_id'=> '',
        'tokens_spent'=>0,
    ];
});
