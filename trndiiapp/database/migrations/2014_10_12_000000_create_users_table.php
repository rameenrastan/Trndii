<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone')->default("Enter a phone number");
            $table->string('addressline1')->default("Enter an address line");
            $table->string('addressline2')->nullable();
            $table->string('postalcode')->default("Enter a postal code");
            $table->string("city")->default("Enter a city");
            $table->string('country')->default("Enter a country");
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('tokens')->default(0);
            $table->string('stripe_id')->nullable();
            $table->string('segment')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
