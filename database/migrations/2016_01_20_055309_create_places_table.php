<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('parent_id')->nullable()->default(null)->unsigned();
            $table->string('name');
        });

        /**
         * Add relationship for parent_id column
         */
        Schema::table('places', function(Blueprint $table)
        {
            $table
                ->foreign('parent_id')
                ->references('id')
                ->on('places')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        /**
         * Default inserts
         */
        DB::table('places')->insert([
            'id'        => 1,
            'parent_id' => null,
            'name'      => 'Polska'
        ]);
        DB::table('places')->insert([
            'id'        => 2,
            'parent_id' => 1,
            'name'      => 'Zakopane'
        ]);
        DB::table('places')->insert([
            'id'        => 3,
            'parent_id' => 1,
            'name'      => 'Sopot'
        ]);
    }
}
