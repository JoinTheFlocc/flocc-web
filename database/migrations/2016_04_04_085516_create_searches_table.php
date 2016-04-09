<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searches', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->timestamp('time')->useCurrent();
            $table->integer('user_id')->unsigned()->nullable()->default(null);
            $table->integer('activity_id')->nullable()->default(null)->unsigned();
            $table->text('place')->nullable()->default(null);
            $table->text('tribes')->nullable()->default(null);
            $table->text('post');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('activity_id')
                ->references('id')
                ->on('activities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
