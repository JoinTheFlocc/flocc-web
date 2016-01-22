<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_members', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('event_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('status', ['awaiting', 'rejected', 'member', 'follower'])->default('awaiting');
            $table->timestamp('join_date')->useCurrent();
            $table->timestamp('status_change_date')->nullable()->default(null);

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
    }
}
