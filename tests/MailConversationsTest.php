<?php

/**
 * Class MailConversationsTest
 */
class MailConversationsTest extends TestCase
{
    public function testGetByIdIsNull()
    {
        $this->assertEquals(null, (new \Flocc\Mail\Conversations())->getById(9999));
    }
}