<?php

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


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\item::class, function (Faker\Generator $faker) {

    return [
        'id' => $faker->unique()->randomNumber(),
        'Name' => $faker->name,
        'Price'=>$faker->randomNumber()/100,
        'Bulk_Price'=>$faker->randomNumber()/100,
        'Threshold'=>$faker->randomNumber(),
        'Tokens_Given'=>$faker->randomNumber(),
        'Short_Description'=>$faker->sentence,
        'Long_Description'=>$faker->sentence,
        'Status'=>$faker->sentence,
        'Start_Date'=>$faker->date,
        'End_Date'=>$faker->date,
        'Picture_URL'=>$faker->imageUrl($width = 800, $height = 600, 'cats'), 
        'created_at'=>$faker->date,
        'updated_at'=>$faker->date
    ];
});