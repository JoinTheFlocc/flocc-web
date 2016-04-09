<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesFeelingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_feelings', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_feelings')->insert(['id' => 1, 'name' => 'nic się nie wyświetli']);
        DB::table('profiles_feelings')->insert(['id' => 2, 'name' => 'potrzeby każdej osoby w grupy są ważne']);
        DB::table('profiles_feelings')->insert(['id' => 3, 'name' => 'zwracam bardzo dużą uwagę na potrzeby innych']);
        DB::table('profiles_feelings')->insert(['id' => 4, 'name' => 'dbanie o potrzeby - brak wyboru']);
    }
}
