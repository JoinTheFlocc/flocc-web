<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesAlcoholTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_alcohol', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_alcohol')->insert(['id' => 1, 'name' => 'Sporadycznie lub wcale']);
        DB::table('profiles_alcohol')->insert(['id' => 2, 'name' => 'Od czasu do czasu']);
        DB::table('profiles_alcohol')->insert(['id' => 3, 'name' => 'Chętnie']);
    }
}
