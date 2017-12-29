<?php

use Illuminate\Database\Seeder;

class PurchasedItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PurchasedItem::class, 30)->create();
    }
}
