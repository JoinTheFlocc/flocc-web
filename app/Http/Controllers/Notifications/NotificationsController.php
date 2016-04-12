<?php

namespace Flocc\Http\Controllers\Notifications;

use Flocc\Auth;
use Flocc\Http\Controllers\Controller;
use Flocc\Notifications\Notifications;

/**
 * Class NotificationsController
 *
 * @package Flocc\Http\Controllers\Notifications
 */
class NotificationsController extends Controller
{
    /**
     *  Get notifications JSON
     *
     * @param null|string $type
     * @param bool $only_unread
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotifications($type = null, $only_unread = true)
    {
        /**
         * Notification type
         */
        if($type !== null) {
            if(in_array($type, ['mail.new']) === false) {
                $type = null;
            }
        }

        if(\Auth::user()) {
            $notifications  = new Notifications();
            $data           = $notifications->getByUserId(\Auth::user()->id, $only_unread, $type);

            return response()->json($data->toArray());
        }

        return response()->json([]);
    }

    /**
     * User notifications list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('notifications.index', [
            'data' => $this->getNotifications(null, false)->getData()
        ]);
    }

    /**
     * Run notification callback
     *
     * @param int $id
     *
     * @return mixed
     */
    public function callback($id)
    {
        $notifications = new Notifications();

        return $notifications->doCallback($id, \Auth::user()->id);
    }

    public function delete($id)
    {
        $notifications  = new Notifications();
        $notification   = $notifications->getById($id);

        if($notification) {
            if($notification->user_id === Auth::getUserId()) {
                $notification->delete();
            }
        }

        return \Redirect::to('notifications');
    }
}