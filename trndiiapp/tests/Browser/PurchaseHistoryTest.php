<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PurchaseHistoryTest extends DuskTestCase
{
    /**
     * Tests viewing purchase history.
     *
     * @return void
     */
    public function testPurchaseHistory()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->type('email', 'sammoosavi94@gmail.com')
            ->type('password', 'test123')
            ->press('Login')
            ->click('a[href="/purchaseHistory"]')
            ->assertSee('test')
            ->assertSee('12')
            ->assertSee('this is a test');
        });
    }
}
