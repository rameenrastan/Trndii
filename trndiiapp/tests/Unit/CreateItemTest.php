<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use App;
use DB;
use App\Repositories;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Model;
use Log;

class CreateItemTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * tests the creation of a new item
     *
     * @return void
     */
    public function testCreateItem()
    {
        putenv('DB_CONNECTION=sqlite_testing');

        $request = new Request();

        $item = factory(\App\item::class)->make();

        $request->Name=$item->Name;
        $request->Price=$item->Price;
        $request->Bulk_Price=$item->Bulk_Price;
        $request->Actual_Price=$item->Actual_Price;
        $request->Tokens_Given=($item->Price - $item->Bulk_Price);
        $request->Threshold=$item->Threshold;
        $request->Short_Description=$item->Short_Description;
        $request->Long_Description=$item->Long_Description;
        $request->Category=$item->Category;
        $request->Start_Date=$item->Start_Date;
        $request->End_Date=$item->End_Date;
        $request->Picture_URL=$item->Picture_URL;
        $request->Shipping_To=$item->Shipping_To;
        $request->Supplier=$item->Supplier;

        $itemRepo = new App\Repositories\ItemRepository();

        Log::shouldReceive('info');

        $itemRepo->store($request);  

        $this->assertDatabaseHas('items', [
            'Name' => $request->Name, 
            'Price' => $request->Price,
            'Bulk_Price' => $request->Bulk_Price,
            'Tokens_Given' => $request->Tokens_Given,
            'Threshold' => $request->Threshold,
            'Short_Description' => $request->Short_Description,
            'Long_Description' => $request->Long_Description,
            'Start_Date' => $request->Start_Date,
            'End_Date' => $request->End_Date,
            'Picture_URL' => $request->Picture_URL,
            'Shipping_To' => $request->Shipping_To,
            'Supplier' => $request->Supplier
        ]);

     }
    
    }
 
 