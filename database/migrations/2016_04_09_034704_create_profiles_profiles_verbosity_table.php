<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesProfilesVerbosityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_verbosity', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_verbosity')->insert(['id' => 1, 'name' => 'Małomówny']);
        DB::table('profiles_verbosity')->insert(['id' => 2, 'name' => 'Średnia']);
        DB::table('profiles_verbosity')->insert(['id' => 3, 'name' => 'Gaduła']);
    }
}
