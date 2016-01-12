<?php

/**
 * Class MailLabelsTest
 */
class MailLabelsTest extends TestCase
{
    public function testGetUserInboxID()
    {
        $this->assertInternalType('int', (new \Flocc\Mail\Labels())->getUserInboxID(1));
    }

    public function testCreateDefaultLabelsForNonExistsUser()
    {
        $this->assertFalse((new \Flocc\Mail\Labels())->createDefaultLabels(9999));
    }
}