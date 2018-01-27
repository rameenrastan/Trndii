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
                ->type('email', 'test@test.com')
                ->type('name', 'test user 2 ')
                    ->type('password', 'test1234')
                    ->type('password_confirmation', 'test1234')
                    ->press('Register')
                    ->assertSee('The email has already been taken.');
        });
    }
}
