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
            'event'                 => $this->getEventTitle(),
            'user'                  => $this->getUserName(),
            'user_id'               => $this->getTimeLineUserId(),
            'event_slug'            => $this->getEventSlug(),
            'event_description'     => $this->getEventDescription()
        ];
    }
}