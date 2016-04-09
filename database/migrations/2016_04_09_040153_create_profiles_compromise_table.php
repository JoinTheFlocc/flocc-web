<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesCompromiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_compromise', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_compromise')->insert(['id' => 1, 'name' => 'zawsze i z każdym znajdę kompromis']);
        DB::table('profiles_compromise')->insert(['id' => 2, 'name' => 'potrafię iść na kompromis']);
        DB::table('profiles_compromise')->insert(['id' => 3, 'name' => 'nie lubię kompromisów']);
        DB::table('profiles_compromise')->insert(['id' => 4, 'name' => 'ugodowość - brak wyboru']);
    }
}
