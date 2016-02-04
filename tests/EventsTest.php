<?php

/**
 * Class EventsTest
 */
class EventsTest extends TestCase
{
    public function testEvent()
    {
        $events = new \Flocc\Events\Events();
        $event  = $events->getById(1);

        $this->assertInstanceOf('\Flocc\Events\Events', $event);
    }

    public function testBudget()
    {
        $events = new \Flocc\Events\Events();
        $event  = $events->getById(1);

        $this->assertInstanceOf('\Flocc\Budgets', $event->getBudget());
    }

    public function testIntensity()
    {
        $events = new \Flocc\Events\Events();
        $event  = $events->getById(1);

        $this->assertInstanceOf('\Flocc\Intensities', $event->getIntensity());
    }

    public function testUser()
    {
        $events = new \Flocc\Events\Events();
        $event  = $events->getById(1);

        $this->assertInstanceOf('\Flocc\User', $event->getOwner());
    }

    public function testPlace()
    {
        $events = new \Flocc\Events\Events();
        $event  = $events->getById(1);

        $this->assertInstanceOf('\Flocc\Places', $event->getPlace());
    }

    public function testRoute()
    {
        $events = new \Flocc\Events\Events();
        $event  = $events->getById(1);

        $this->assertInstanceOf('\Flocc\Places', $event->getRoutes());
    }

    public function testActivities()
    {
        $events = new \Flocc\Events\Events();
        $event  = $events->getById(1);

        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $event->getRoutes());
    }

    public function testMembers()
    {
        $events = new \Flocc\Events\Events();
        $event  = $events->getById(1);

        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $event->getMembers());
    }

    public function testTimeLine()
    {
        $events = new \Flocc\Events\Events();
        $event  = $events->getById(1);

        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $event->getTimeLine());
    }

    public function testIsMine()
    {
        $events = new \Flocc\Events\Events();
        $event  = $events->getById(1);

        $this->assertFalse($event->isMine());
    }
}
