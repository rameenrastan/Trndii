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

$factory->define(App\item::class, function (Faker $faker) {
    $end = $faker->dateTime();
    $start = $faker->dateTime($end);

    return [
        'Name' => $faker->domainName,
        'Price'=> $price = $faker->randomFloat(2, 10, 250),
        'Bulk_Price'=> number_format(max($price / $users = $faker->numberBetween(1, 50), $price / 10), 2),
        'Threshold'=>max($users - 5, 5),
        'tokens_Given'=>0,
        'Short_Description'=>$faker->words(random_int(3, 5), true),
        'Long_Description' => $faker->paragraphs('3', true),
        'Status' => $faker->randomElement(['pending']),
        'Start_Date' => $start,
        'End_Date' => $end,
        'Picture_URL' => $faker->imageUrl('250', '250'),
        'Shipping_To' => $faker->regexify('H[0-9]{1}[A-Z]{1} [0-9]{1}[A-Z]{1}[0-9]{1}'),
    ];
});
