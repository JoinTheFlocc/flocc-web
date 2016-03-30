<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_comments', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->integer('parent_id')->nullable()->default(null)->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('time')->useCurrent();
            $table->longText('comment');
            $table->timestamp('last_comment_time')->nullable()->default(null);
            $table->enum('label', ['public','private'])->default('public');

            $table
                ->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        /**
         * Add relationship for parent_id column
         */
        Schema::table('events_comments', function(Blueprint $table)
        {
            $table
                ->foreign('parent_id')
                ->references('id')
                ->on('events_comments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
