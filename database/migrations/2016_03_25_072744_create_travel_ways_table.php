<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelWaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_ways', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('travel_ways')->insert(['id' => 1, 'name' => 'A']);
        DB::table('travel_ways')->insert(['id' => 2, 'name' => 'B']);
        DB::table('travel_ways')->insert(['id' => 3, 'name' => 'C']);
    }
}
