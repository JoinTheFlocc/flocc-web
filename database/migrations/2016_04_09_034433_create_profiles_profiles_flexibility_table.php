<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesProfilesFlexibilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_flexibility', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_flexibility')->insert(['id' => 1, 'name' => 'Lubię spontaniczność']);
        DB::table('profiles_flexibility')->insert(['id' => 2, 'name' => 'Tworzę ramowy plan']);
        DB::table('profiles_flexibility')->insert(['id' => 3, 'name' => 'Tworzę dokładny plan']);
    }
}
