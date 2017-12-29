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

        $admin = new admin;
        $admin->name = "testAdmin";
        $admin->email = "admin@admin.com";
        $admin->password = Hash::make('password');
        $admin->save();

    }
}
