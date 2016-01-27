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
            $table->integer('budget_id')->unsigned();
            $table->integer('intensities_id')->unsigned();

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
        });
    }
}
