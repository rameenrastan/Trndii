<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCancelPurchase extends DuskTestCase
{
    /**
     * Tests removing an item as an admin.
     *
     * @return void
     */
    public function testCancelPurchase()
    {

        //Need valid test credit card

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email', 'test@test.com')
                ->type('password', 'password')
                ->press('Login')
                ->visit('/item/100')
                ->press('Purchase')
                ->pause(1000)
                ->press('Confirm')
                ->assertSee('You have successfully commited to this purchase.')
                ->visit('/purchaseHistory')
                ->press('Cancel')
                ->pause(1000)
                ->press('Confirm')
                ->assertSee('You have successfully deleted testItem from your pending transactions!')

            ;});
    }
}
