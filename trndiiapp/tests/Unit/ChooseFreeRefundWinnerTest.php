<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\TokenManager;
use Mockery;

class ChooseFreeRefundWinnerTest extends TestCase
{
    /**
     * Tests that a user is properly selected for a free refund from the pool of users who spent 0 tokens on an item. 
     *
     * @return void
     */
    public function testChooseFreeRefundWinner()
    {
        $userRepoMock = Mockery::mock('App\Repositories\UserRepository');
        $itemRepoMock = Mockery::mock('App\Repositories\ItemRepository');
        $transactionRepoMock = Mockery::mock('App\Repositories\TransactionRepository');

        //makes 10 users
        $users = factory(\App\User::class, 10)->make();
        
        $tokenManager = new TokenManager($userRepoMock, $transactionRepoMock, $itemRepoMock);

        $winner = $tokenManager->chooseNoTokenWinner($users);

        $winnerName = $winner->name;

        $this->assertNotNull($winner);
        $this->assertEquals($winnerName, $winner->name);

    }
}
