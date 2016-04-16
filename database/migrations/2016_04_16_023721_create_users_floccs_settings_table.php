<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersFloccsSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_floccs_settings', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('flocc_id')->unsigned();
            $table->string('name', 50);
            $table->string('value', 50);

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('flocc_id')
                ->references('id')
                ->on('users_floccs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
