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
        return preg_replace("#\[b\](.*?)\[/b\]#si", '<strong>\\1</strong>', $this->element->message);
    }
}