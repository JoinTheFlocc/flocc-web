<?php

namespace Flocc\Notifications;

/**
 * Class Callbacks
 *
 * @package Flocc\Notifications
 */
class Callbacks
{
    private $action, $callback;

    public function __construct($action, $callback)
    {
        $this->action   = $action;
        $this->callback = $callback;
    }

    /**
     * Execute
     *
     * @return mixed
     */
    public function exec()
    {
        switch($this->action) {
            case 'redirect':
                return $this->redirect();
        }
    }

    /**
     * Redirect URL
     *
     * @return mixed
     */
    private function redirect()
    {
        return \Redirect::to($this->callback);
    }
}