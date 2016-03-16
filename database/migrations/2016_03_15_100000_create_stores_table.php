<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('store_code', 10);
            $table->string('trade_name', 250);
            $table->string('name', 250);
            $table->integer('category');
            $table->text('address');
            $table->string('barangay', 250);
            $table->string('district', 250);
            $table->string('city', 250);
            $table->string('province', 250);
            $table->integer('zip_code');
            $table->string('region', 250);
            $table->string('island_group', 10);
            $table->float('latitude');
            $table->float('longitude');
            $table->dateTime('date_opened');
            $table->float('size');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stores');
    }
}
