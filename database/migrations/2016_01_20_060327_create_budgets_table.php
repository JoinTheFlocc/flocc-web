<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
        });

        /**
         * Default inserts
         */
        DB::table('budgets')->insert(['id' => 1, 'name' => 'Malo']);
        DB::table('budgets')->insert(['id' => 2, 'name' => 'Srednio']);
        DB::table('budgets')->insert(['id' => 3, 'name' => 'Duzo']);
    }
}
