<?php

use Illuminate\Database\Seeder;
use App\admin;
use App\supplier;


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

        $supplier = new supplier;
        $supplier->name = "FakeSupplier";
        $supplier->email = "sup@sup.com";
        $supplier->password = Hash::make('password');
        $supplier->save();

        $supplier = new supplier;
        $supplier->name = "Suprimo";
        $supplier->email = "sup1@sup.com";
        $supplier->password = Hash::make('password');
        $supplier->save();

        $supplier = new supplier;
        $supplier->name = "Quinn and Val";
        $supplier->email = "sup2@sup.com";
        $supplier->password = Hash::make('password');
        $supplier->save();

        // items
        $this->call(ItemsTableSeeder::class);

        // Categories
        $this->call(CategorySeeder::class);

        // pre-registered users
        $this->call(PreRegisteredUserTableSeeder::class);

        // admins
        $this->call(AdminsTableSeeder::class);

        // transactions
        $this->call(TransactionsTableSeeder::class);
    }
}