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
        factory(App\item::class, 50)->create();


        $admin = new admin;
        $admin->name = "testAdmin";
        $admin->email = "admin@admin.com";
        $admin->password = Hash::make('password');
        $admin->save();

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


    }
}
