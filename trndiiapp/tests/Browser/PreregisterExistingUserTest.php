<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PreregisterExistingUserTest extends DuskTestCase
{
    /**
     * Tests the preregistration of an existing user.
     *
     * @return void
     */
    public function testExistingPreregistration()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/preregistration')
                    ->type('firstName', 'test10')
                    ->type('lastName', 'test10')
                    ->type('email', 'test10@test.com')
                    ->press('Submit')
                    ->assertSee('The email has already been taken.');
        });
    }
}
