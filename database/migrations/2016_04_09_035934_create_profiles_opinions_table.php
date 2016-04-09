<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesOpinionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_opinions', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_opinions')->insert(['id' => 1, 'name' => 'nic się nie wyświetli']);
        DB::table('profiles_opinions')->insert(['id' => 2, 'name' => 'ewanelizator']);
    }
}
