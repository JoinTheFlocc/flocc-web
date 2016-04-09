<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesFreeTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_free_time', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_free_time')->insert(['id' => 1, 'name' => 'koncert']);
        DB::table('profiles_free_time')->insert(['id' => 2, 'name' => 'pub/knajpa']);
        DB::table('profiles_free_time')->insert(['id' => 3, 'name' => 'restauracja']);
        DB::table('profiles_free_time')->insert(['id' => 4, 'name' => 'teatr/opera']);
        DB::table('profiles_free_time')->insert(['id' => 5, 'name' => 'imprezy sportowe']);
        DB::table('profiles_free_time')->insert(['id' => 6, 'name' => 'ognisko']);
        DB::table('profiles_free_time')->insert(['id' => 7, 'name' => 'spacer']);
        DB::table('profiles_free_time')->insert(['id' => 8, 'name' => 'książka']);
        DB::table('profiles_free_time')->insert(['id' => 9, 'name' => 'aktywność fizyczna']);
        DB::table('profiles_free_time')->insert(['id' => 10, 'name' => 'konsumpcja']);
    }
}
