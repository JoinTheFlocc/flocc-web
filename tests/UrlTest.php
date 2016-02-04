<?php

/**
 * Class UrlTest
 */
class UrlTest extends TestCase
{
    public function testIsString()
    {
        $this->assertSame('random-string', (new \Flocc\Url())->slug('random string'));
    }
}
