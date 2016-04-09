<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesPlanningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_plannings', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_plannings')->insert(['id' => 1, 'name' => 'Lubię spontaniczność']);
        DB::table('profiles_plannings')->insert(['id' => 2, 'name' => 'Tworzę ramowy plan']);
        DB::table('profiles_plannings')->insert(['id' => 3, 'name' => 'Lubię planować w szczegółach']);
    }
}
