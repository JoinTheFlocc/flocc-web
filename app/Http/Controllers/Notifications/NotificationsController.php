<?php

namespace Flocc\Http\Controllers\Notifications;

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
     * Get notifications JSON
     */
    public function getNotifications()
    {
        $notifications  = new Notifications();
        $data           = $notifications->getByUserId(\Auth::user()->id);

        return response()->json($data->toArray());
    }

    /**
     * User notifications list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('notifications.index', [
            'data' => $this->getNotifications()->getData()
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
}