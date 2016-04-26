<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSatelliteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satellite', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id');
            $table->string('satellite_code', 50);
            $table->string('trade_name_prefix', 100);
            $table->integer('trade_name');
            $table->string('name', 250);
            $table->text('address');
            $table->integer('zip_code');
            $table->integer('region');
            $table->integer('island_group');
            $table->string('area', 250);
            $table->integer('division');
            $table->float('latitude');
            $table->float('longitude');
            $table->string('image', 250);
            $table->string('contact_number', 250);
            $table->dateTime('date_opened');
            $table->float('size');
            $table->boolean('status')->default(1);
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
        Schema::drop('satellite');
    }
}
