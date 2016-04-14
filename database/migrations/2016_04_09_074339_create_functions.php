<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec($this->binarySum());
        DB::connection()->getPdo()->exec($this->dateScore());
        DB::connection()->getPdo()->exec($this->multiPoints());
        DB::connection()->getPdo()->exec($this->eventScore());
    }

    private function binarySum()
    {
        return '
        DROP FUNCTION IF EXISTS `binarySum`;
        DELIMITER $$
        CREATE FUNCTION `binarySum`(a CHAR(6), b CHAR(6)) RETURNS INT(11)
        BEGIN  	
            DECLARE length INT;
            DECLARE compare INT;
            DECLARE loop_i INT;
            
            SET compare 	= 0;
            SET loop_i 		= 1;
            SET length 		= CHAR_LENGTH(a);
        
            IF CHAR_LENGTH(a) > CHAR_LENGTH(b) THEN
                SET length = CHAR_LENGTH(b);
            END IF;
            
            WHILE loop_i < length DO
                IF SUBSTRING(a, loop_i, 1) = \'1\' AND SUBSTRING(b, loop_i, 1) = \'1\' THEN
                    SET compare = compare+1;
                END IF;
                
                SET loop_i = loop_i+1;
            END WHILE;
            
            RETURN compare;
        END;
        $$
        DELIMITER ;
        ';
    }

    private function dateScore()
    {
        return '
        DROP FUNCTION IF EXISTS `dateScore`;
        DELIMITER $$
        CREATE FUNCTION `dateScore` (uod DATE, udo DATE, up INT, wod DATE, wdo DATE, event_span INT) RETURNS float
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
    }

    private function multiPoints()
    {
        return '
        DROP FUNCTION IF EXISTS `multiPoints`;
        DELIMITER $$
        CREATE FUNCTION `multiPoints`(user INT(10), event INT(1))
        RETURNS FLOAT
        BEGIN
            DECLARE points FLOAT;
            
            SET points = 0;
            
            IF user = event THEN
                SET points = 1;
            END IF;
            
            IF user = (event-1) OR user = (event+1) THEN
                SET points = 0.5;
            END IF;
          
            RETURN points;
        END;
        $$
        DELIMITER ;
        ';
    }

    public function eventScore()
    {
        return '
        DROP FUNCTION IF EXISTS `eventScore`;
        DELIMITER $$
        CREATE FUNCTION `eventScore`(__uod DATE, __udo DATE, __up INT, __wod DATE, __wdo DATE, __event_span INT, __u_activity INT, __w_activity INT, __u_tribes INT, __w_tribes INT, __u_place TEXT, __w_place TEXT, __w_route TEXT, __u_voluntary INT(1), __w_voluntary INT(1), __u_language_learning INT(1), __w_language_learning INT(1), __u_budget INT(1), __w_budget INT(1), __u_intensity INT(1), __w_intensity INT(1), __u_travel_ways INT(1), __w_travel_ways INT(1), __u_infrastructure INT(1), __w_infrastructure INT(1), __u_tourist INT(1), __w_tourist INT(1))
        RETURNS FLOAT
        BEGIN
            DECLARE points FLOAT;
            DECLARE tribes_sum INT;
            DECLARE tribes FLOAT;
            DECLARE chars FLOAT;
            
            SET points = 0;
            SET chars = 0;
            
            /**  Aktywność **/
            IF __u_activity IS NOT NULL THEN
                IF __u_activity = __w_activity THEN
                    SET points = points + (1*3.0);
                END IF;
            END IF;
            
            /** JAK / Tribes **/
            IF __u_tribes IS NOT NULL THEN
                SET tribes_sum = binarySum(__u_tribes, __w_tribes);
                SET tribes = tribes_sum * 0.33;
            
                IF tribes > 1 THEN SET tribes = 1; END IF;
            
                SET points = points + ROUND(tribes * 2.0, 2);
            END IF;
            
            /** Miejsce **/
            IF __u_place IS NOT NULL THEN
                IF __u_place = __w_place OR __w_place LIKE CONCAT(\'%,\', __u_place) THEN
                    SET points = points + (1*2.0);
                END IF;
            END IF;
            
            /** Trasa **/
            IF __w_route IS NOT NULL THEN
                IF __w_route LIKE CONCAT(\'%\', __u_place, \'%\') THEN 
                    SET points = points + (1*2.0);
                END IF;
            END IF;
            
            /** Kiedy **/
            SET points = points+dateScore(__uod, __udo, __up, __wod, __wdo, __event_span);
            
            /** Budżet **/
            IF __u_budget IS NOT NULL THEN
                SET chars = chars+(multiPoints(__u_budget, __w_budget)*0.33);
            END IF;
            
            /** Intensywność **/
            IF __u_intensity IS NOT NULL THEN
                SET chars = chars+(multiPoints(__u_intensity, __w_intensity)*0.33);
            END IF;
            
            /** Sposób podróżowania **/
            IF __u_travel_ways IS NOT NULL THEN
                SET chars = chars+(multiPoints(__u_travel_ways, __w_travel_ways)*0.33);
            END IF;
            
            /** Infrastruktura **/
            IF __u_infrastructure IS NOT NULL THEN
                SET chars = chars+(multiPoints(__u_infrastructure, __w_infrastructure)*0.33);
            END IF;
            
            /** Turystyczność **/
            IF __u_tourist IS NOT NULL THEN
                SET chars = chars+(multiPoints(__u_tourist, __w_tourist)*0.33);
            END IF;
            
            /** Suma z cech **/
            SET points = points+chars;
            
            /** Wolontariat **/
            IF __u_voluntary IS NOT NULL THEN
                IF __u_voluntary = 1 AND __w_voluntary = 1 THEN
                    SET points = points+1;
                END IF;
            END IF;
            
            /** Nauka języków **/
            IF __u_language_learning IS NOT NULL THEN
                IF __u_language_learning = 1 AND __w_language_learning = 1 THEN
                    SET points = points+1;
                END IF;
            END IF;
          
            RETURN points;
        END;
        $$
        DELIMITER ;
        ';
    }
}
