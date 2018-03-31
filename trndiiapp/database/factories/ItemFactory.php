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
        'Bulk_Price'=> $bulk_price=number_format(max($price / $users = $faker->numberBetween(1, 50), $price / 1.4), 2),
        'Actual_Price'=> $actual_price=number_format(max($bulk_price / $users = $faker->numberBetween(1, 50), $price /1.5 ), 2),
        'Threshold'=>max($users - 5, 5),
        'tokens_Given'=>intval($price-$bulk_price),
        'Short_Description'=>$faker->words(random_int(3, 5), true),
        'Long_Description' => $faker->paragraphs('3', true),
        'Status' => $faker->randomElement(['pending']),
        'Start_Date' => $start,
        'Category' => $faker->randomElement(['Appliances', 'Electronics', 'Misc']),
        'End_Date' => $end,
        'Picture_URL' => $faker->imageUrl('250', '250'),
        'Shipping_To' => $faker->randomElement(['Canada', 'US', 'Canada/US']),
        'Supplier' => $faker->randomElement(['FakeSupplier', 'Suprimo', 'Quinn and Val']),
    ];
});
