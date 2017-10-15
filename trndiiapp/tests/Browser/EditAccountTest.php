<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditAccountTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->assertSee('You are logged in!')
                    ->visit('/editDetails')
                    ->type('phone', '1234567890')
                    ->type('address', '123 test street')
                    ->type('postalcode', 'abc123')
                    ->select('country')
                    ->press('Update')
                    ->assertSee('Account Details Updated!');
        });
    }
}
