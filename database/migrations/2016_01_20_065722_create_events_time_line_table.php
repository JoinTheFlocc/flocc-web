<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTimeLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_time_line', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->enum('type', ['message', 'comment'])->default('message');

            $table->integer('comment_id')->nullable()->default(null)->unsigned();
            $table->integer('message_id')->nullable()->default(null)->unsigned();

            $table
                ->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('comment_id')
                ->references('id')
                ->on('events_comments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('message_id')
                ->references('id')
                ->on('events_messages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
