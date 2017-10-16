<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminAddItemIncompleteTest extends DuskTestCase
{
    /**
     * Tests the creation of a new item with missing fields.
     *
     * @return void
     */
    public function testAddIncompleteItem()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
            ->type('email', 'sammoosavi94@gmail.com')
            ->type('password', 'test123')
            ->press('Login')
            ->visit('/item/create')
            ->keys('#start-date', '2017', '{tab}', '09', '15')
            ->keys('#end-date', '2018', '{tab}', '02', '20')
            ->press('Create Item')
            ->assertSee('Errors')
            ->assertSee('The name field is required.')
            ->assertSee('The tokens given field is required.')
            ->assertSee('The threshold field is required.')
            ->assertSee('The short description field is required.')
            ->assertSee('The long description field is required.');
            
        });
    }
}
