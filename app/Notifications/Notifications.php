<?php

namespace Flocc\Notifications;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notifications
 *
 * @package Flocc\Notifications
 */
class Notifications extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['notification_id', 'user_id', 'is_read', 'sent_time', 'read_time', 'unique_key', 'type_id', 'callback'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get user notifications
     *
     * @param int $user_id
     * @param bool $unread
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByUserId($user_id, $unread = true)
    {
        $variables  = new Variables();
        $get        = self::where('user_id', (int) $user_id)->orderBy('notification_id');

        if($unread === true) {
            $get->where('is_read', '0');
        }

        /**
         * Types
         */
        $get = $get->join('notifications_types', 'notifications.type_id', '=', 'notifications_types.type_id');

        /**
         * Get data
         */
        $data = $get->get();

        /**
         * variables
         */
        foreach($data as $row) {
            $row->variables     = $variables->getArrayByNotificationId($row->notification_id);
            $row->name          = $this->prepareNotificationName($row->name, $row->variables);
        }

        return $data;
    }

    /**
     * Prepare notification name + variables
     *
     * @param string $name
     * @param array $variables
     *
     * @return string
     */
    private function prepareNotificationName($name, array $variables)
    {
        foreach($variables as $key => $value) {
            $name = str_replace('{{ $' . $key . ' }}', $value, $name);
        }

        return $name;
    }

    /**
     * Do notification callback
     *
     * @param int $id
     * @param int $user_id
     *
     * @return mixed
     */
    public function doCallback($id, $user_id)
    {
        $notification = self::where('notification_id', (int) $id)
            ->where('user_id', (int) $user_id)
            ->where('is_read', '0')
            ->join('notifications_types', 'notifications.type_id', '=', 'notifications_types.type_id')
            ->take(1)
        ->first();

        if($notification !== null) {
            /**
             * Mark as read
             */
            self::where('notification_id', (int) $notification->notification_id)->update([
                'is_read'   => '1',
                'read_time' => \DB::raw('CURRENT_TIMESTAMP')
            ]);

            /**
             * Do callback
             */
            return (new Callbacks($notification->action, $notification->callback))->exec();
        }

        return \Redirect::to('notifications');
    }

    public function isExistsCheckByUniqueKey($unique_key, $user_id)
    {
        $notification = self::where('user_id', (int) $user_id)
            ->where('unique_key', $unique_key)
            ->where('is_read', '0')
            ->take(1)
        ->first();

        return ($notification === null) ? false : true;
    }

    /**
     * Save new notification
     *
     * @param NewNotification $notification
     *
     * @return bool
     */
    public function addNewNotification(\Flocc\Notifications\NewNotification $notification)
    {
        if($this->isExistsCheckByUniqueKey($notification->getUniqueKey(), $notification->getUserId()) === false) {
            $new                = new Notifications();

            $new->user_id       = $notification->getUserId();
            $new->sent_time     = \DB::raw('current_timestamp');
            $new->unique_key    = $notification->getUniqueKey();
            $new->type_id       = $notification->getTypeId();
            $new->callback      = $notification->getCallback();

            $info               = ($new->save() == 0) ? false : true;
            $id                 = (int) \DB::getPdo()->lastInsertId();

            /**
             * Save variables
             */
            if($info === true) {
                foreach($notification->getVariables() as $name => $value) {
                    $variable                       = new Variables();

                    $variable->notification_id      = $id;
                    $variable->name                 = $name;
                    $variable->value                = $value;

                    $variable->save();
                }
            }

            return $info;
        }

        return false;
    }
}
