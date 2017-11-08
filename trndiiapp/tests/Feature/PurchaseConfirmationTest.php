<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Mail\PurchaseConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PurchaseConfirmationTest extends TestCase
{
    /**
     * Tests Purchase Confirmation mailable class.
     *
     * @return void
     */
    public function testExample()
    {

        Mail::fake();
        
        $user = factory(\App\User::class)->create([
            
            'name' => "Rameen",
            'email' => "rameenrastanv@hotmail.com"

        ]);

        $item = factory(\App\item::class)->create([
            'Name' => "Test item",
            'Price' => "1000",
            'Bulk_Price' => "10000",
            'Threshold' => "30",
            'Short_Description' => 'test description',

        ]);

        Mail::assertSent(PurchaseConfirmation::class, function ($mail) use ($item, $user) {

            return $mail->$item->id === $item->id;

        });
    }
}
