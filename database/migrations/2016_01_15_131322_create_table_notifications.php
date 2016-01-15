<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function(Blueprint $table)
        {
            $table->increments('notification_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('is_read', ['0', '1'])->default('0');
            $table->timestamp('sent_time')->useCurrent();
            $table->timestamp('read_time')->nullable()->default(null);
            $table->char('unique_key', 32);
            $table->string('type_id', 50);
            $table->text('callback')->nullable()->default(null);

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table
                ->foreign('type_id')
                ->references('type_id')
                ->on('notifications_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
