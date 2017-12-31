<?php

use Illuminate\Database\Seeder;

class PreRegisteredUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\PreregisteredUser::class, 10)->create();
    }
}
