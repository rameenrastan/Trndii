<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ShoppingCartTest extends DuskTestCase
{
    /**
     * Tests the shopping cart.
     *
     * @return void
     */
    public function testShoppingCart()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->visit('/item')
                    ->assertSee('Add To Cart')
                    ->visit('/shoppingCart')
                    ->assertSee('Items in your shopping cart');
        });
    }
}
