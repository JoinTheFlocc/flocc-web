<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesPartyingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_partying', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_partying')->insert(['id' => 1, 'name' => 'Sporadycznie']);
        DB::table('profiles_partying')->insert(['id' => 2, 'name' => 'Od czasu do czasu']);
        DB::table('profiles_partying')->insert(['id' => 3, 'name' => 'Lubię dużo imprezować']);
    }
}
