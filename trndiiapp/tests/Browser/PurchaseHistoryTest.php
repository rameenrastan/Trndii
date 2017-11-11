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
            ->type('password', 'test1234')
            ->press('Login')
            ->visit('/purchaseHistory')
            ->click('a[href="#home"]')
            ->click('a[href="#menu1"]')
            ->click('a[href="#menu2"]');
        });
    }
}
