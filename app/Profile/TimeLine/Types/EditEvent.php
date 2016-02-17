<?php

namespace Flocc\Profile\TimeLine\Types;

/**
 * Class EditEvent
 *
 * @package Flocc\Profile\TimeLine\Types
 */
class EditEvent extends ParentType
{
    /**
     * Get time line message
     *
     * @return array
     */
    public function getMessage()
    {
        return [
            'event'             => $this->getEventTitle(),
            'user_id'           => $this->getTimeLineUserId(),
            'event_slug'        => $this->getEventSlug(),
            'user'              => $this->getUserName(),
        ];
    }
}