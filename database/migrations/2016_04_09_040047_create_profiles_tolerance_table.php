<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesToleranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_tolerance', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_tolerance')->insert(['id' => 1, 'name' => 'bardzo tolerancyjny']);
        DB::table('profiles_tolerance')->insert(['id' => 2, 'name' => 'tolerancyjny']);
        DB::table('profiles_tolerance')->insert(['id' => 3, 'name' => 'mało tolerancyjny']);
        DB::table('profiles_tolerance')->insert(['id' => 4, 'name' => 'toleracyjność - brak wyboru']);
    }
}
