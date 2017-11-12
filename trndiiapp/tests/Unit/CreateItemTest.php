<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Tests\TestCase;
use Carbon\Carbon;
use App;
use DB;
use App\Http\Controllers;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Model;

class CreateItemTest extends TestCase
{

    public function setUp() {

        parent::setUp();
        Model::unguard();

    }

    /**
     * tests the creation of a new item
     *
     * @return void
     */
    public function testCreateItem()
    {

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $request = new Request();

        $request->Name = 'test';
        $request->Price = '10';
        $request->Bulk_Price = '100';
        $request->Tokens_Given = '10';
        $request->Threshold = 30;
        $request->Short_Description = 'test';
        $request->Long_Description = 'this is a test';
        $request->Start_Date = $today;
        $request->End_Date = $tomorrow;
        $request->Picture_URL = 'https://lorempixel.com/800/600/cats/?96914';
 
        $controller = new App\Http\Controllers\ItemsController();

        $controller->store($request);  

        $this->assertDatabaseHas('items', [
            'Name' => 'test', 
            'Price' => '10', 
            'Bulk_Price' => '100',
            'Tokens_Given' => '10',
            'Threshold' => 30,
            'Short_Description' => 'test',
            'Long_Description' => 'this is a test',
            'Start_Date' => $today,
            'End_Date' => $tomorrow,
            'Picture_URL' => 'https://lorempixel.com/800/600/cats/?96914'
        ]);

     }
    
    }
 
 