<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_messages', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->text('message');

            $table
                ->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
