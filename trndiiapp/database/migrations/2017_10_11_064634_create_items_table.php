<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Name');
            $table->double('Price',15, 2);
            $table->double('Bulk_Price');
            $table->integer('Threshold');
            $table->integer('Tokens_Given');
            $table->integer('Total_Tokens_Spent')->default(0);
            $table->string('Short_Description');
            $table->text('Long_Description');
            $table->string('Category');
            $table->string('Status');
            $table->integer('Number_Transactions')->default(0);
            $table->datetime('Start_Date');
            $table->datetime('End_Date');
            $table->string('Picture_URL');
            $table->string('Shipping_To');
            $table->string('Supplier');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
