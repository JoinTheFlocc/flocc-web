<?php

namespace Flocc\Cron;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cron
 *
 * @package Flocc\Cron
 */
class Cron extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cron';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'active', 'schedule', 'namespace', 'method'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    private $schedules = ['minute','5minutes','10minutes','hourly','daily','weekly','monthly','mondays','tuesdays','wednesdays','thursdays','fridays','saturdays','sundays'];

    /**
     * Get namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get method
     *
     * @return method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Execute cron
     *
     * @param string $schedule
     *
     * @return int
     */
    public function execute($schedule)
    {
        $logs   = new Logs();
        $i      = 0;

        if(in_array($schedule, $this->schedules) === false) {
            $logs->put("schedule " . $schedule . " doesn't exists");

            return 0;
        }

        $logs->put('start cron for ' . $schedule);

        $jobs = self::where('schedule', $schedule)->where('active', '1')->get();

        if($jobs->count() > 0) {
            foreach($jobs as $job) {
                $class_name = $job->getNamespace();

                if(class_exists($class_name)) {
                    $class          = new $class_name;
                    $method_name    = $job->getMethod();

                    if(method_exists($class, $method_name)) {
                        $output = $class->$method_name();

                        if($output === true) {
                            ++$i;

                            $logs->put($class_name . '->' . $method_name . "() > OK");
                        } else {
                            $logs->put($class_name . '->' . $method_name . "() > FAIL > " . $output);
                        }
                    } else {
                        $logs->put("Method ' . $method_name . ' in class ' . $class_name . ' doesn't exists");
                    }
                } else {
                    $logs->put("Class ' . $class_name . ' doesn't exists");
                }
            }
        }

        $logs->put('End cron for ' . $schedule . ' with ' . $i . ' iterations')->done();

        return $i;
    }
}