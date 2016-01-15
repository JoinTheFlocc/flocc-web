<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_messages', function(Blueprint $table)
        {
            $table->increments('message_id')->unsigned();
            $table->integer('conversation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('sent_time')->useCurrent();
            $table->timestamp('read_time')->nullable()->default(null);
            $table->longText('message');

            $table
                ->foreign('conversation_id')
                ->references('conversation_id')
                ->on('mail_conversations')
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
