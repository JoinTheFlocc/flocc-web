<?php

namespace Flocc\Notifications;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Types
 *
 * @package Flocc\Notifications
 */
class Types extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type_id', 'name', 'action'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Is type exists
     *
     * @param string $type_id
     *
     * @return bool
     */
    public function isTypeExists($type_id)
    {
        return (self::where('type_id', $type_id)->take(1)->first() === false) ? false : true;
    }
}