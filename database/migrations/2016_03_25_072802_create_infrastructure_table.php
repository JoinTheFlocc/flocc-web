<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfrastructureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infrastructure', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('infrastructure')->insert(['id' => 1, 'name' => 'A']);
        DB::table('infrastructure')->insert(['id' => 2, 'name' => 'B']);
        DB::table('infrastructure')->insert(['id' => 3, 'name' => 'C']);
    }
}
