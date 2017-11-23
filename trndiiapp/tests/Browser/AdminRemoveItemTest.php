<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminRemoveItemTest extends DuskTestCase
{
    /**
     * Tests removing an item as an admin.
     *
     * @return void
     */
    public function testAdminRemoveItem()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->visit('/viewAllItems')
                    ->press('Delete')
                    ->acceptDialog()
                    ->assertSee('Item removed!');
        });
    }
}
