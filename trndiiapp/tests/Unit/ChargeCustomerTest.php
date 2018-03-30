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

class ChargeCustomerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Tests that the token money pool (total savings) is calculated properly. 
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
}
