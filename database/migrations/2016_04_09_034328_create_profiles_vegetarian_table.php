<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesVegetarianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_vegetarian', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_vegetarian')->insert(['id' => 1, 'name' => 'Tak']);
        DB::table('profiles_vegetarian')->insert(['id' => 2, 'name' => 'Nie']);
    }
}
