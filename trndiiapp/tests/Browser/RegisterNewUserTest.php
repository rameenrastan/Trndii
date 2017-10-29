<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterNewUserTest extends DuskTestCase
{
    /**
     * Tests registration of a new user.
     *
     * @return void
     */
    public function testNewRegistration()
    {
        
        $this->browse(function (Browser $browser) {
            $string = str_random(40);
            $browser->visit('/register')
                ->type('name', 'Jason')
                ->type('email', $string . '@test.com')
                ->type('password', 'test123')
                ->type('password_confirmation', 'test123')
                ->press('Register')
                ->assertSee('You are logged in!');
        });
    }
}
