<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntensitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intensities', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('intensities')->insert(['id' => 1, 'name' => 'Relaks']);
        DB::table('intensities')->insert(['id' => 2, 'name' => 'Aktywnie']);
        DB::table('intensities')->insert(['id' => 3, 'name' => 'Wyczynowo']);
    }
}
