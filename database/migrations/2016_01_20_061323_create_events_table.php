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
CREATE FUNCTION `eventScore` (uod DATE, udo DATE, up INT, wod DATE, wdo DATE, event_span INT) RETURNS float
BEGIN
  DECLARE wp INT;
  DECLARE upmax INT;
  DECLARE czw INT;
  
  /** Liczenie perdod dla wydarzenia **/
    IF event_span <= 2 THEN SET wp = 1; SET upmax = 2; END IF;
    IF event_span >= 3 AND event_span <= 5 THEN SET wp = 2; SET upmax = 5; END IF;
    IF event_span >= 6 AND event_span <= 14 THEN SET wp = 3; SET upmax = 14; END IF;
    IF event_span > 14 THEN SET wp = 4; SET upmax = 14; END IF;

  /** Liczenie scoringu **/
  
  /** 1 **/
  IF (uod <= wod) and (wdo <= udo) and (up = wp) THEN
    RETURN 1;
  END IF;  
  
  /** 4 **/
  IF ((uod <= wod) and (wod <= udo) and (wdo >= udo)) or ((wod <= udo) and (uod <= wdo) and (wdo <= udo)) THEN
    IF (uod <= wod) and (wod <= udo) and (wdo >= udo) THEN SET czw = DATEDIFF(udo, wod); END IF;
    IF (wod <= udo) and (uod <= wdo) and (wdo <= udo) THEN SET czw = DATEDIFF(wdo, uod); END IF;
    
    /** a **/
    IF (upmax <= czw) THEN RETURN 0.9; END IF;
    /**  b **/
    IF (upmax > czw) and (up = wp) THEN RETURN 0.75; END IF;
    /** c **/
    IF (upmax > czw) and (up <> wp) THEN RETURN 0.5; END IF;
  END IF;
  
  /** 7.1 **/
  IF (wod <= uod) and (udo <= wdo) and (up = wp) THEN
    RETURN 0.8;
  END IF;
  
  /** 2 **/
  IF (uod <= wod) and (wdo <= udo) and (up = wp-1 or up = wp+1) THEN
    RETURN 0.75;
  END IF;
  
  /** 7.2 **/
  IF (wod <= uod) and (udo <= wdo) and (up = wp-1 or up=wp+1) THEN
    RETURN 0.7;
  END IF;
  
  /** 3 **/
  IF (uod <= wod) and (wdo <= udo) and (up = wp-2 or up = wp+2) THEN
    RETURN 0.6;
  END IF;
  
  /** 7.3 **/
  IF (wod <= uod) and (udo <= wdo) and (up = wp-2 or up=wp+2) THEN
    RETURN 0.5;
  END IF;
  
  /** 5 **/
  IF (wod < uod) and (wdo > udo) and (up = wp) THEN
    RETURN 0.25;
  END IF;
  
  RETURN 0;
END;
$$
DELIMITER ;
        ';

        DB::connection()->getPdo()->exec($sql);
    }
}
