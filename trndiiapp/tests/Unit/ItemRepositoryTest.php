<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use App\Repositories;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemRepositoryTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * Testing the @update fucntion in Item repository
     *Expected to change status of item assosiated to the ID to cancelled
     * @return void
     */
    public function testUpdateRepository()
    {
        $test_item = new \App\item([
            'id' => "1",
            'Name'=> "testItem",
            'Price'=> 1,
            'Bulk_Price'=>1,
            'Threshold'=>20,
            'Tokens_Given'=>0,
            'Short_Description' => "test short description",
            'Long_Description' => "test long description",
            'Category'=>"Electronics",
            'Status'=>"pending",
            'Number_Transactions'=>0,
            'Start_Date'=>"2018-01-14 00:20:09",
            'End_Date'=>"2018-08-14 00:20:09",
            'Picture_URL'=>"test.jpg",
            'Shipping_To'=>"Canada",
            'Supplier'=>"FakeSupplier",
            'created_at'=>"2018-01-14 00:20:09",
            'updated_at'=>"2018-01-14 00:20:09"
        ]);

        $test_item->save();

        $repository = new Repositories\ItemRepository();
        $repository->update(1);


        $this->assertDatabaseHas('items', [
            'id' => '1',
            'Status' => 'cancelled'
        ]);

//       $this->assertTrue(false);
    }

    /**
     * Testing wether our system , correctly creates and stores an item via a request.
     * @return void
     */
    public function testFindAnItem()
    {
        $test_item = new \App\item([
            'id' => "100",
            'Name'=> "testItem",
            'Price'=> 1,
            'Bulk_Price'=>1,
            'Threshold'=>20,
            'Tokens_Given'=>0,
            'Short_Description' => "test short description",
            'Long_Description' => "test long description",
            'Category'=>"Electronics",
            'Status'=>"pending",
            'Number_Transactions'=>0,
            'Start_Date'=>"2018-01-14 00:20:09",
            'End_Date'=>"2018-08-14 00:20:09",
            'Picture_URL'=>"test.jpg",
            'Shipping_To'=>"Canada",
            'Supplier'=>"FakeSupplier",
            'created_at'=>"2018-01-14 00:20:09",
            'updated_at'=>"2018-01-14 00:20:09"
        ]);

        $test_item->save();


        $repository = new Repositories\ItemRepository();
        $item_from_search=    $repository->find(100);

        $this->assertTrue(
        $item_from_search->Name==$test_item->Name &&
        $item_from_search->Price==$test_item->Price &&
        $item_from_search->Bulk_Price==$test_item->Bulk_Price &&
        $item_from_search->Tokens_Given==$test_item->Tokens_Given &&
        $item_from_search->Threshold==$test_item->Threshold &&
        $item_from_search->Short_Description==$test_item->Short_Description &&
        $item_from_search->Long_Description==$test_item->Long_Description &&
        $item_from_search->Category==$test_item->Category &&
        $item_from_search->Start_Date==$test_item->Start_Date &&
        $item_from_search->Status == $test_item->Status &&
        $item_from_search->End_Date==$test_item->End_Date &&
        $item_from_search->Picture_URL==$test_item->Picture_URL &&
        $item_from_search->Shipping_To==$test_item->Shipping_To &&
        $item_from_search->Supplier==$test_item->Supplier
    );

//       $this->assertTrue(($test_item == $item_from_search));
    }
}
