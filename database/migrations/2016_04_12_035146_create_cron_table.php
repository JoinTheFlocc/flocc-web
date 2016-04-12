<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cron', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->enum('active', ['0', '1'])->default('1');
            $table->enum('schedule', ['minute','5minutes','10minutes','hourly','daily','weekly','monthly','mondays','tuesdays','wednesdays','thursdays','fridays','saturdays','sundays'])->default('daily');
            $table->string('namespace');
            $table->string('method');
        });

        /**
         * Default inserts
         */
        DB::table('cron')->insert(['id' => 1, 'active' => '1', 'schedule' => 'daily', 'namespace' => '\Flocc\Events\Events', 'method' => 'closeAfterDate']);
        DB::table('cron')->insert(['id' => 2, 'active' => '1', 'schedule' => 'daily', 'namespace' => '\Flocc\Events\Events', 'method' => 'sendStartingAndEndingEventsNotifications']);
    }
}
