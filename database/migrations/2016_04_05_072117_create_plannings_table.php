<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plannings', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('plannings')->insert(['id' => 1, 'name' => 'Spontan']);
        DB::table('plannings')->insert(['id' => 2, 'name' => 'Ramowy plan']);
        DB::table('plannings')->insert(['id' => 3, 'name' => 'Sztywny plan']);
    }
}
