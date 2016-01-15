<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_labels', function(Blueprint $table)
        {
            $table->increments('label_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name', 45);
            $table->enum('type', ['inbox','trash','archive'])->nullable()->default(null);
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
