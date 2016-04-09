<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesEmergencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_emergency', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_emergency')->insert(['id' => 1, 'name' => 'działam']);
        DB::table('profiles_emergency')->insert(['id' => 2, 'name' => 'dostosowuje sie']);
        DB::table('profiles_emergency')->insert(['id' => 3, 'name' => 'wkurzam się']);
        DB::table('profiles_emergency')->insert(['id' => 4, 'name' => 'panikuję']);
        DB::table('profiles_emergency')->insert(['id' => 5, 'name' => 'załamuję się']);
        DB::table('profiles_emergency')->insert(['id' => 6, 'name' => 'nic nie robię']);
    }
}
