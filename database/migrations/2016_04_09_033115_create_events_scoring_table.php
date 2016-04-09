<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsScoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_scoring', function(Blueprint $table)
        {
            $table->increments('event_id')->unsigned();
            $table->integer('activity_id')->unsigned()->nullable()->default(null);
            $table->string('tribes', '15')->nullable()->default(null);
            $table->text('place')->nullable()->default(null);
            $table->text('route')->nullable()->default(null);

            $table
                ->foreign('event_id')
                ->references('id')
                ->on('events')
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
