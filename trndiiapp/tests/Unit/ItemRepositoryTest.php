<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Repositories;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemRepositoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateRepository()
    {


        $repository = new Repositories\ItemRepository();
        $repository->update(1);


        $this->assertDatabaseHas('items', [
            'id' => '1',
            'Status' => 'cancelled'
        ]);

//        $this->assertTrue(false);
    }
}
