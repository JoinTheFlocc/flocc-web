<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_plans', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_plans')->insert(['id' => 1, 'name' => 'Realizuję plan mimo wszystko']);
        DB::table('profiles_plans')->insert(['id' => 2, 'name' => 'Dostosowuję się do zmian']);
    }
}
