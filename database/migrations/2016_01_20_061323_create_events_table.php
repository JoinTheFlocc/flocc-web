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

        /**
         * Create eventScore function
         */
        $sql = '
        DROP FUNCTION IF EXISTS `eventScore`;
        DELIMITER $$
        CREATE FUNCTION `eventScore`(date_from DATE, date_to DATE, event_from DATE, event_to DATE, period INT) RETURNS float
        BEGIN
          DECLARE score FLOAT;
          DECLARE days INT;
          DECLARE event_days INT;
          DECLARE event_period INT;

          SET score = 0;
          SET event_days = DATEDIFF(event_to, event_from);

          /** Liczenie perdod dla wydarzenia **/
          IF event_days <= 2 THEN SET event_period = 1; END IF;
          IF event_days >= 3 AND event_days <= 5 THEN SET event_period = 2; END IF;
          IF event_days >= 6 AND event_days <= 14 THEN SET event_period = 3; END IF;
          IF event_days > 14 THEN SET event_period = 4; END IF;

          /** Liczenie ilości pokrywających się dni **/
          IF event_from >= date_from and event_to <= date_to THEN
            SET days = DATEDIFF(event_to, event_from);
          END IF;

          IF event_from < date_from and event_to > date_to THEN
            SET days = DATEDIFF(event_from, event_from);
          END IF;

          IF event_from < date_from and event_to < date_to THEN
            SET days = DATEDIFF(event_to, date_from)+1;
          END IF;

          IF event_from > date_from and event_to > date_to THEN
            SET days = DATEDIFF(date_to, event_from);
          END IF;

          IF days < 1 THEN
            SET days = 0;
          END IF;

          /** Liczenie scoringu **/

          IF event_from >= date_from and event_to <= date_to THEN
            IF event_days = days THEN
                SET score = 1;
            ELSEIF period = (event_period-1) OR period = (event_period+1) THEN
                SET score = 0.75;
            ELSE
                SET score = 0.6;
            END IF;
          END IF;

          IF days > 0 THEN
            IF period = event_period THEN
                SET score = 1;
            ELSE
                SET score = 0.5;
            END IF;
          ELSE
            IF period = event_period THEN
                SET score = 0.25;
            END IF;
          END IF;

          RETURN score;
        END;
        $$
        DELIMITER ;
        ';

        DB::connection()->getPdo()->exec($sql);
    }
}
