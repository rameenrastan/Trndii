<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewItemTest extends DuskTestCase
{
    /**
     * Tests viewing items.
     *
     * @return void
     */
    public function testViewItems()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test1234')
                    ->press('Login')
                    ->visit('/item')
                    ->assertSee('Browsing Items')
                    ->click('a[href="item/1"]')
                    ->assertSee('Price: ')
                    ->assertSee('Tokens gained: ')
                    ->assertSee('Days Remaining: ')
                    ->assertSee('Orders Placed');
        });
    }
}
