<?php

namespace Flocc\Profile\TimeLine\Types;

/**
 * Class NewMember
 *
 * @package Flocc\Profile\TimeLine\Types
 */
class NewMember extends ParentType
{
    /**
     * Get time line message
     *
     * @return array
     */
    public function getMessage()
    {
        return [
            'user'      => $this->getUserName(),
            'type'      => $this->getType(),
            'event'     => $this->getEventTitle()
        ];
    }
}