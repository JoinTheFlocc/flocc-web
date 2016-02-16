<?php

namespace Flocc\Profile\TimeLine\Types;

/**
 * Class NewEvent
 *
 * @package Flocc\Profile\TimeLine\Types
 */
class NewEvent extends ParentType
{
    /**
     * Get time line message
     *
     * @return array
     */
    public function getMessage()
    {
        return [
            'event' => $this->getEventTitle()
        ];
    }
}