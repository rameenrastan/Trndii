<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SupplierLoginTest extends DuskTestCase
{
    /**
     * Tests the login of a supplier.
     *
     * @return void
     */
    public function testSupplierLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/supplier/login')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->visit('/supplier')
                    ->assertSee('Supplier Homepage');
        });
    }
}
