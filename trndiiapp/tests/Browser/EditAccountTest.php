<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditAccountTest extends DuskTestCase
{
    /**
     * Tests editing a user's account information.
     *
     * @return void
     */
    public function testEditAccount()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('email', 'test@test.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->visit('/editDetails')
                    ->type('phone', '5142223333')
                    ->type('addressline1', '123 test street')
                    ->type('addressline2', '123 test2 street')
                    ->type('postalcode', 'J5Y 3A1')
                    ->type('city', 'Montreal')
                    ->type('password', 'password')
                    ->type('newpassword', 'test1234')
                    ->type('confirmnewpassword', 'test1234')
                    ->select('country', 'Canada')
                    ->press('Update')
                    ->assertSee('Account Details Updated!');
        });
    }
}
