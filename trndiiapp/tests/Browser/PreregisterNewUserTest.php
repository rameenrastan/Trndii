<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PreregisterNewUserTest extends DuskTestCase
{
    /**
     * Tests the preregistration of a new user.
     *
     * @return void
     */
    public function testNewPreregistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/preregistration')
                    ->type('firstName', 'Alex')
                    ->type('lastName', 'Smith')
                    ->type('email', 'alexsmith@test.com')
                    ->press('Submit')
                    ->assertSee('Thank you for your interest! You will be notified via email when the website goes live.');
        });
    }
}
