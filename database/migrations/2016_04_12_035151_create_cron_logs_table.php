<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cron_logs', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->timestamp('time')->useCurrent();
            $table->longText('message');
        });
    }
}
