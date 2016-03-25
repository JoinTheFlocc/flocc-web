<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTouristTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourist', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('tourist')->insert(['id' => 1, 'name' => 'A']);
        DB::table('tourist')->insert(['id' => 2, 'name' => 'B']);
        DB::table('tourist')->insert(['id' => 3, 'name' => 'C']);
    }
}
