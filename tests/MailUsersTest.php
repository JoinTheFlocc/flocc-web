<?php

/**
 * Class Users
 */
class MailUsersTest extends TestCase
{
    public function testIsUserInConversation()
    {
        $this->assertFalse((new \Flocc\Mail\Users())->isUserInConversation(false, 'string'));
    }

    public function testUpdateByConversationIdAndUserId()
    {
        $this->assertFalse((new \Flocc\Mail\Users())->updateByConversationIdAndUserId(9999, 1111, ['user_id' => 1]));
    }

    public function testUpdateUnreadMessages()
    {
        $this->assertEquals(2, (new \Flocc\Mail\Users())->updateUnreadMessages(14));
    }

    public function testGetUserConversations()
    {
        $this->assertInstanceOf('\Illuminate\Support\Collection', (new \Flocc\Mail\Users())->getUserConversations(1, 1));
    }
}
