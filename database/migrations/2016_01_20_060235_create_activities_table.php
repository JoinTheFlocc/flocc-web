<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('activities')->insert(['id' => 1, 'name' => 'Żagle']);
        DB::table('activities')->insert(['id' => 2, 'name' => 'Kajaki']);
        DB::table('activities')->insert(['id' => 3, 'name' => 'Backpacking']);
    }
}
