<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SupplierViewItems extends DuskTestCase
{
    /**
     * Tests viewing supplier items.
     *
     * @return void
     */
    public function testSupplierViewItems()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/supplier/login')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->visit('/supplier')
                    ->assertSee('Supplier Homepage')
                    ->visit('/supplier/items')
                    ->assertSee('Your Items');
        });
    }
}
