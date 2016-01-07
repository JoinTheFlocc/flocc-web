<?php

namespace Flocc\Notifications;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Variables
 *
 * @package Flocc\Notifications
 */
class Variables extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications_variables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['variable_id', 'notification_id', 'name', 'value'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get variables
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByNotificationId($id)
    {
        return self::where('notification_id', (int) $id)->get();
    }

    /**
     * Get array with variables
     *
     * @param int $id
     *
     * @return array
     */
    public function getArrayByNotificationId($id)
    {
        $get    = $this->getByNotificationId($id);
        $data   = [];

        foreach($get as $row) {
            $data[$row->name] = $row->value;
        }

        return $data;
    }
}