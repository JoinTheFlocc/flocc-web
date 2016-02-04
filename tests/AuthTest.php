<?php

/**
 * Class AuthTest
 */
class AuthTest extends TestCase
{
    public function testIsNull()
    {
        $this->assertEquals(null, \Flocc\Auth::getUserId());
    }
}
