<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('profiles_features', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->enum('is_set', ['0', '1'])->default('0');
        });

        /**
         * Default inserts
         */
        DB::table('profiles_features')->insert(['id' => 1, 'name' => 'nie przejmuję się formami towarzystkimi, bezceremonialny, poufale żartobliwy', 'is_set' => '1']);
        DB::table('profiles_features')->insert(['id' => 2, 'name' => 'umiejący zachować się adekwatnie do sytuacji i osób z którymi ma w danej chwili doczynienia', 'is_set' => '1']);
        DB::table('profiles_features')->insert(['id' => 3, 'name' => 'stonowany, zasadniczny, poważny, zdystansowany, przestrzega reguł towarzyskich', 'is_set' => '1']);
        DB::table('profiles_features')->insert(['id' => 4, 'name' => 'spokojny', 'is_set' => '0']);
        DB::table('profiles_features')->insert(['id' => 5, 'name' => 'stonowany', 'is_set' => '0']);
        DB::table('profiles_features')->insert(['id' => 6, 'name' => 'dusza towarzystwa', 'is_set' => '0']);
        DB::table('profiles_features')->insert(['id' => 7, 'name' => 'niecierpliwy', 'is_set' => '0']);
        DB::table('profiles_features')->insert(['id' => 8, 'name' => 'spontaniczny', 'is_set' => '0']);
        DB::table('profiles_features')->insert(['id' => 9, 'name' => 'inne - dodaj przez moderatora', 'is_set' => '0']);
    }
}
