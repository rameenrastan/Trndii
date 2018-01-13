<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BrowseItemsByCategoryTest extends DuskTestCase
{
    /**
     * Tests browsing items by category.
     *
     * @return void
     */
    public function testBrowseItemsByCategory()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->visit('/browseItemsByCategory')
                    ->assertSee('Browse Items By Category');
        });
    }
}
