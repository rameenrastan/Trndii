<?php

use Illuminate\Database\Seeder;


class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $test_item = new \App\item([
            'Name'=> "testItem",
            'Price'=> 5,
            'Bulk_Price'=>4,
            'Actual_Price'=>3,
            'Threshold'=>20,
            'Tokens_Given'=>1,
            'Short_Description' => "test short description",
            'Long_Description' => "test long description",
            'Category'=>"Electronics",
            'Status'=>"pending",
            'Number_Transactions'=>0,
            'Start_Date'=>"2018-01-14 00:20:09",
            'End_Date'=>"2018-08-14 00:20:09",
            'Picture_URL'=>"test.jpg",
            'Shipping_To'=>"Canada",
            'Supplier'=>"FakeSupplier",
            'created_at'=>"2018-01-14 00:20:09",
            'updated_at'=>"2018-01-14 00:20:09"
        ]);

        $test_item->save();

        factory(App\item::class, 50)->create();
    }
}
