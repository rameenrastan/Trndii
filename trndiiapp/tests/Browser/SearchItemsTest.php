<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SearchItemsTest extends DuskTestCase
{
    /**
     * Tests searching items.
     *
     * @return void
     */
    public function testSearchItems()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->type('search', 'test')
                    ->press('searchButton')
                    ->assertSee('Search Results');
        });
    }
}
