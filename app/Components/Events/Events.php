<?php
namespace Flocc\Components\Events;

class Events
{
    public static $events = array();

    public static function trigger($event, $args = array())
    {
        if(isset(self::$events[$event])) {
            foreach(self::$events[$event] as $func) {
                return call_user_func_array($func, $args);
            }
        }

        return false;
    }

    public static function bind($event, \Closure $func)
    {
        self::$events[$event][] = $func;
    }
}