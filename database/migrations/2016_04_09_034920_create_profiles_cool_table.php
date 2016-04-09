<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesCoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_cool', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_cool')->insert(['id' => 1, 'name' => 'Mało wylozowany']);
        DB::table('profiles_cool')->insert(['id' => 2, 'name' => 'Wyluzowany']);
        DB::table('profiles_cool')->insert(['id' => 3, 'name' => 'Totalny luzak']);
    }
}
