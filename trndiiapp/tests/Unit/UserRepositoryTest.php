<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories;
use App\User;

class UserRepositoryTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * Testing the updated credit card values for a user
     *
     * @return void
     */
    public function testUpdateCreditCard()
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
        ]);

        $test_user->save();


        $repository = new Repositories\UserRepository();
        $repository->updateCreditCard("test@test.com", 123);


        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
            'stripe_id'=>'123'
        ]);
    }
}
