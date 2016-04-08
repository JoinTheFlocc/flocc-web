<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamp('created_at')->useCurrent();
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->date('event_from')->nullable()->default(null);
            $table->date('event_to')->nullable()->default(null);
            $table->smallInteger('event_span')->nullable()->unsigned();
            $table->integer('views')->default(0);
            $table->string('avatar_url')->nullable();
            $table->smallInteger('users_limit')->unsigned();
            $table->enum('fixed', ['0', '1'])->default('0');
            $table->enum('status', ['draft', 'open','private','close','canceled'])->default('draft');
            $table->integer('place_id')->nullable()->default(null)->unsigned();
            $table->integer('budget_id')->nullable()->default(null)->unsigned();
            $table->integer('intensities_id')->nullable()->default(null)->unsigned();
            $table->integer('travel_ways_id')->nullable()->default(null)->unsigned();
            $table->integer('infrastructure_id')->nullable()->default(null)->unsigned();
            $table->integer('tourist_id')->nullable()->default(null)->unsigned();
            $table->enum('voluntary', ['0', '1'])->default('0');
            $table->enum('language_learning', ['0', '1'])->default('0');
            $table->enum('is_inspiration', ['0', '1'])->default('0');
            $table->enum('event_month', ['1','2','3','4','5','6','7','8','9','10','11','12'])->nullable()->default(null);
            $table->integer('last_update_time')->unsigned();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('place_id')
                ->references('id')
                ->on('places')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table
                ->foreign('budget_id')
                ->references('id')
                ->on('budgets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('intensities_id')
                ->references('id')
                ->on('intensities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('tribe_id')
                ->references('id')
                ->on('tribes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('travel_ways_id')
                ->references('id')
                ->on('travel_ways')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('infrastructure_id')
                ->references('id')
                ->on('infrastructure')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('tourist_id')
                ->references('id')
                ->on('tourist')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
}
