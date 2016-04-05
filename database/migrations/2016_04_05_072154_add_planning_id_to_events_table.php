<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanningIdToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('events', 'planning_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->integer('planning_id')->nullable()->default(null)->unsigned();

                $table
                    ->foreign('planning_id')
                    ->references('id')
                    ->on('plannings')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
        }
    }
}
