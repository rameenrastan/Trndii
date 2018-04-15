<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Domain\PaymentManager;
use Mockery;
use Log;
use Mail;
use Stripe\{Stripe, Charge, Customer, Refund};
use App\Repositories;
use App\Transaction;
use App\User;
use App\Domain\TokenManager;

class ChargeCustomerTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * Tests that a customer is charged and an associated charge id is created.
     *
     * @return void
     */
    public function testChargeCustomer()
    {
        putenv('DB_CONNECTION=sqlite_testing');
        
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $userRepoMock = Mockery::mock('App\Repositories\UserRepository');
        $itemRepoMock = Mockery::mock('App\Repositories\ItemRepository');
        $transactionRepoMock = Mockery::mock('App\Repositories\TransactionRepository');
        $tokenManager = Mockery::mock('App\Domain\TokenManager');  

        $customer = Customer::create([

            'email' => 'test@test.com',
            'source' => 'tok_visa' 
    
           ]);

        $user = factory(\App\User::class)->create([
            'stripe_id' => $customer
        ]);

        $user->save();
        
        Log::shouldReceive('info');
        Mail::fake();

        $paymentManager = new PaymentManager(new Mail, new Log, $userRepoMock, $transactionRepoMock, $itemRepoMock, $tokenManager);
        
        $chargeId = $paymentManager->charge(100, $user->stripe_id);

        $this->assertNotNull($chargeId);
    }

    /**
     * Tests all business logic processing upon purchase completion 
     * (token cash back distribution, choosing lottery winner, etc)
     *
     * @return void
     */
    public function testPurchaseCompletion()
    {
        putenv('DB_CONNECTION=sqlite_testing');
        
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $transactionRepo = new Repositories\TransactionRepository(new Transaction);
        $userRepo = new Repositories\UserRepository(new User);
        $itemRepo = new Repositories\ItemRepository;
        $tokenManager = new TokenManager($userRepo, $transactionRepo, new Repositories\ItemRepository);
        $paymentManager = new PaymentManager(new Mail, new Log, 
                                             $userRepo, $transactionRepo,
                                             $itemRepo, $tokenManager);
        Mail::fake();
        Log::shouldReceive('info');

        $item = factory(\App\item::class)->make([
            'Threshold' =>  1,
            'Total_Tokens_Spent' => 100
        ]);

        $item->save();

        $customer = Customer::create([

            'email' => 'test@test.com',
            'source' => 'tok_visa' 
    
           ]);

        $user = factory(\App\User::class)->create([
            'stripe_id' => $customer
        ]);

        $user->save();

        $this->be($user);

        $chargeId = $paymentManager->charge(100000, $user->stripe_id);
        
        $transactionRepo->insert($user->email, $item->id, $chargeId, 0);
        
        $chargeId = $paymentManager->purchaseCompletion($item->id);
    }
}
