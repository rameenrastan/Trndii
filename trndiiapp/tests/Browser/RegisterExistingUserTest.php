<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterExistingUserTest extends DuskTestCase
{
    /**
     * Tests registration of an existing user.
     *
     * @return void
     */
    public function testRegisterExistingUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'Sam Moosavi')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->type('password_confirmation', 'test123')
                    ->press('Register')
                    ->assertSee('The email has already been taken.');
        });
    }
}
