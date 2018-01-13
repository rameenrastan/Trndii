<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $category = new \App\Category([
            'name' => 'Appliances'
        ]);
        $category->save();

        $category = new \App\Category([
            'name' => 'Electronics'
        ]);
        $category->save();

        $category = new \App\Category([
            'name' => 'Misc'
        ]);
        $category->save();




        //        factory(App\Category::class, 20)->create();
    }
}
