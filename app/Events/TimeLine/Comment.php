<?php

namespace Flocc\Events\TimeLine;

use Flocc\Events\TimeLine\Parents\Element;

/**
 * Class Comment
 *
 * @package Flocc\Events\TimeLine
 */
class Comment extends Element
{
    /**
     * Get comment text
     *
     * @return string
     */
    public function getComment()
    {
        return $this->element->comment;
    }
}