<?php

namespace Flocc\Cron;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Logs
 *
 * @package Flocc\Cron
 */
class Logs extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cron_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'time', 'message'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    private $messages = [];

    /**
     * Add log
     *
     * @param string $message
     * 
     * @return $this
     */
    public function put($message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Save array logs
     *
     * @return static
     */
    public function done()
    {
        return Logs::create(['message' => implode("\n", $this->messages)]);
    }
}