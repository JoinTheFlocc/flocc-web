<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tribes', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('tribes')->insert(['id' => 1, 'name' => 'Outdoor']);
        DB::table('tribes')->insert(['id' => 2, 'name' => 'Nightlife']);
        DB::table('tribes')->insert(['id' => 3, 'name' => 'Adventure']);
        DB::table('tribes')->insert(['id' => 4, 'name' => 'Culture']);
        DB::table('tribes')->insert(['id' => 5, 'name' => 'Foodies']);
        DB::table('tribes')->insert(['id' => 6, 'name' => 'Sightseeing']);
    }
}
