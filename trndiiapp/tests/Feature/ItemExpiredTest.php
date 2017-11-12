<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Mail\ItemExpired;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ItemExpiredTest extends TestCase
{
    /**
     * Tests Item Expired mailable class.
     *
     * @return void
     */
    public function testItemExpired()
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

        Mail::assertSent(ItemExpired::class, function ($mail) use ($item, $user) {

            return $mail->$item->id === $item->id;

        });
    }
}
