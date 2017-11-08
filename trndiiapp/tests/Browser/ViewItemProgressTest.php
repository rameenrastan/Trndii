<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewItemProgressTest extends DuskTestCase
{
    /**
     * Tests viewing item progress.
     *
     * @return void
     */
    public function testViewItemProgress()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('email', 'sammoosavi94@gmail.com')
                    ->type('password', 'test123')
                    ->press('Login')
                    ->click('a[href="/viewProgress"]')
                    ->assertSee('test')
                    ->assertSee('12')
                    ->assertSee('this is a test')
                    ->assertSee('pending')
                    ->assertSee('0')
                    ->assertSee('1');
        });
    }
}
