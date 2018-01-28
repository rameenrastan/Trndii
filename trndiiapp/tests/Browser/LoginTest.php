<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * Tests User Login
     *
     * @return void
     */
    public function testLogin()
    {


        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->type('email', 'test@test.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertSee("Welcome to Trndii! If you're not sure where to start, click ");
        });
    }
}
