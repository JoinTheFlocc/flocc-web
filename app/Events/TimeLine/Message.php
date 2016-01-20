<?php

namespace Flocc\Events\TimeLine;

use Flocc\Events\TimeLine\Parents\Element;

/**
 * Class Message
 *
 * @package Flocc\Events\TimeLine
 */
class Message extends Element
{
    /**
     * Get message text
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->element->message;
    }
}