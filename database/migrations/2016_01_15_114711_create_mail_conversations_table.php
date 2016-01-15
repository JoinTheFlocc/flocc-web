<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_conversations', function(Blueprint $table)
        {
            $table->increments('conversation_id')->unsigned();
            $table->timestamp('start_time')->useCurrent();
            $table->timestamp('last_message_time')->nullable()->default(null);
        });
    }
}
