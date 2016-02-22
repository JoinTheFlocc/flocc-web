<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileTimeLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_time_line', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('time')->useCurrent();
            $table->enum('type', ['new_member', 'new_follower', 'new_comment', 'edit_event', 'new_event'])->default('new_member');
            $table->enum('event_type', ['owner', 'member', 'follower'])->default('owner');

            $table->integer('time_line_user_id')->nullable()->default(null)->unsigned();
            $table->integer('time_line_event_comment_id')->nullable()->default(null)->unsigned();
            $table->integer('time_line_event_id')->nullable()->default(null)->unsigned();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('time_line_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('time_line_event_comment_id')
                ->references('id')
                ->on('events_comments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('time_line_event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
