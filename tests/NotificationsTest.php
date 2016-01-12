<?php

/**
 * Class NotificationsTest
 */
class NotificationsTest extends TestCase
{
    public function testIsJson()
    {
        $this->get('/notifications/get')->seeJson();
    }
}
