<?php

use Illuminate\Database\Seeder;
use App\admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // users
        $this->call(UsersTableSeeder::class);

        // items
        $this->call(ItemsTableSeeder::class);

        // pre-registered users
        $this->call(PreRegisteredUserTableSeeder::class);

        // admins
        $this->call(AdminsTableSeeder::class);
    }
}
