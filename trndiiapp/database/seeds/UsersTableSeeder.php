<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $test_user = new User([
            'name' => "Test User",
            'phone'=> "5145555555",
            'addressline1'=> "1455 Boulevard de Maisonneuve O, Montreal, QC H3G 1M8",
            'postalcode'=>"H3G 1M8",
            'city'=>"Montreal",
            'country'=>'Canada',
            'email' => "test@test.com",
            'password' => bcrypt('password'),
            'status' => "Normal",
        ]);

        $test_user->save();

        factory(App\User::class, 20)->create();
    }
}
