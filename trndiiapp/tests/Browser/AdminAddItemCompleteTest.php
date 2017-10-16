<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminAddItemCompleteTest extends DuskTestCase
{
    /**
     * Tests the creation of a new item with all fields filled.
     *
     * @return void
     */
    public function testAddCompleteItem()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->visit('/item/create')
                    ->type('Name', 'test')
                    ->type('Price', '12.00')
                    ->type('Bulk Price', '12.00')
                    ->type('Tokens Given', '3')
                    ->type('Threshold', '1')
                    ->type('Short Description', 'this is a test')
                    ->type('Long Description', 'this is another test')
                    ->keys('#start-date', '2017', '{tab}', '09', '15')
                    ->keys('#end-date', '2018', '{tab}', '02', '20')
                    ->press('Create Item')
                    ->assertSee('Success:Item has been successfully created');
        });
    }
}
