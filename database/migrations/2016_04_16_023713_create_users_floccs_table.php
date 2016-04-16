<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersFloccsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_floccs', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->string('email', 100)->nullable()->default(null);
            $table->timestamp('time')->useCurrent();
            $table->integer('activity_id')->nullable()->default(null);
            $table->text('place')->nullable()->default(null);
            $table->text('tribes')->nullable()->default(null);

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
