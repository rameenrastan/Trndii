<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewItemTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->click('a[href="item"]')
                    ->assertSee('test')
                    ->click('a[href="item/1"]')
                    ->assertSee('test')
                    ->assertSee('12')
                    ->assertSee('12')
                    ->assertSee('3')
                    ->assertSee('1')
                    ->assertSee('this is a test')
                    ->assertSee('this is another test');
        });
    }
}
