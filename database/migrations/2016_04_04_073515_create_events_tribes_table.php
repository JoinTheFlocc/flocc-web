<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_tribes', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->integer('tribe_id')->unsigned();

            $table
                ->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('tribe_id')
                ->references('id')
                ->on('tribes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
