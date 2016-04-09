<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesProfilesVigorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_vigor', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_vigor')->insert(['id' => 1, 'name' => 'Mało energiczny']);
        DB::table('profiles_vigor')->insert(['id' => 2, 'name' => 'Średnia']);
        DB::table('profiles_vigor')->insert(['id' => 3, 'name' => 'Energiczny']);
    }
}
