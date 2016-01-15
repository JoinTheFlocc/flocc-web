<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_variables', function(Blueprint $table)
        {
            $table->increments('variable_id')->unsigned();
            $table->integer('notification_id')->unsigned();
            $table->string('name', 40);
            $table->text('value');

            $table
                ->foreign('notification_id')
                ->references('notification_id')
                ->on('notifications')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
