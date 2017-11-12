<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditAccountIncompleteTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testEditAccountIncomplete()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->visit('/editDetails')
                    ->type('phone', '')
                    ->type('addressline1', '')
                    ->type('addressline2', '')
                    ->type('postalcode', '')
                    ->type('city', '')
                    ->select('country', '')
                    ->press('Update')
                    ->assertSee('The phone field is required.')
                    ->assertSee('The addressline1 field is required.')
                    ->assertSee('The postalcode field is required.')
                    ->assertSee('The city field is required.')
                    ->assertSee('The country field is required.');

        });
    }
}
