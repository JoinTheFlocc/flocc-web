<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles_rules', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_rules')->insert(['id' => 1, 'name' => 'mało obowiązkowy']);
        DB::table('profiles_rules')->insert(['id' => 2, 'name' => 'nic się nie wyświetli']);
        DB::table('profiles_rules')->insert(['id' => 3, 'name' => 'obowiązkowy odpowiedzialny']);
        DB::table('profiles_rules')->insert(['id' => 4, 'name' => 'obowiązkowość względem grupy - brak wyboru']);
    }
}
