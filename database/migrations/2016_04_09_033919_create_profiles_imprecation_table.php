<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesImprecationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_imprecation', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_imprecation')->insert(['id' => 1, 'name' => 'Tak']);
        DB::table('profiles_imprecation')->insert(['id' => 2, 'name' => 'Nie']);
    }
}
