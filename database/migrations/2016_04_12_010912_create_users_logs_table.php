<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_logs', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('type', ['users.registry','users.login','users.logout','events.create','events.search','events.display'])->default('users.login');
            $table->timestamp('time')->useCurrent();
            $table->integer('search_id')->unsigned()->nullable()->default(null);
            $table->integer('event_id')->unsigned()->nullable()->default(null);

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('search_id')
                ->references('id')
                ->on('searches')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
