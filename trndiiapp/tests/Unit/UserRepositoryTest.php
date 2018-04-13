<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories;
use App\User;
use Log;
use Mockery;

class UserRepositoryTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * Tests updating a user's credit card information
     *
     * @return void
     */
    public function testUpdateCreditCard()
    {

        putenv('DB_CONNECTION=sqlite_testing');

        $user = factory(\App\User::class)->make();

        $this->be($user);

        $user->save();

        Log::shouldReceive('info');

        $repository = new Repositories\UserRepository(new User);
        $repository->updateCreditCard($user->email, 'test_credit_card');


        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'stripe_id'=>'test_credit_card'
        ]);
    }

    /**
     * Tests finding a user by email
     *
     * @return void
     */
    public function testFindByEmail()
    {

        putenv('DB_CONNECTION=sqlite_testing');

        $user = factory(\App\User::class)->make();

        $user->save();

        Log::shouldReceive('info');

        $repository = new Repositories\UserRepository(new User);
        $expectedEmail = $user->email;
        $email = $repository->findByEmail($user->email);


        $this->assertDatabaseHas('users', [
            'email' => $expectedEmail
        ]);
    }

    /**
     * Tests removing tokens from a user.
     *
     * @return void
     */
    public function testRemoveUserTokens()
    {

        putenv('DB_CONNECTION=sqlite_testing');

        $tokens = 100;

        $user = factory(\App\User::class)->make([
            'tokens' => $tokens
        ]);

        $user->save();

        Log::shouldReceive('info');

        $removedTokens = 50;

        $repository = new Repositories\UserRepository(new User);
        $expectedEmail = $user->email;
        $email = $repository->removeTokens($user, $removedTokens);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'tokens' => $tokens - $removedTokens
        ]);

        
    }

    /**
     * Tests adding tokens to a user.
     *
     * @return void
     */
    public function testAddUserTokens()
    {

        putenv('DB_CONNECTION=sqlite_testing');

        $tokens = 100;

        $user = factory(\App\User::class)->make([
            'tokens' => $tokens
        ]);

        $user->save();

        Log::shouldReceive('info');

        $removedTokens = 50;

        $repository = new Repositories\UserRepository(new User);
        $expectedEmail = $user->email;
        $email = $repository->addTokens($user, $removedTokens);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'tokens' => $tokens + $removedTokens
        ]);

        
    }




}
