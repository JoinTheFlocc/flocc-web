<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_users', function(Blueprint $table)
        {
            $table->integer('conversation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('label_id')->unsigned();
            $table->enum('is_owner', ['0', '1'])->default('0');
            $table->integer('unread_messages')->default(0);
            $table->enum('is_important', ['0', '1'])->default('0');

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

            $table
                ->foreign('label_id')
                ->references('label_id')
                ->on('mail_labels')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
