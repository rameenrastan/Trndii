<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('front_page_hits')->default(0);
            $table->integer('number_purchases')->default(0);
            $table->integer('population_size')->default(0);
        });

        DB::table('experiments')->insert(
            array(
                'name' => 'Basic'
            )
        );

        DB::table('experiments')->insert(
            array(
                'name' => 'Token'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experiments');
    }
}
