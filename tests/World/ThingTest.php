<?php

use Forkwars\World\Thing;

class ThingTest extends \ProphecyTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test parentship from a child viewpoint.
     * Attach and detach clean both sides of the relation.
     */
    public function testAttachToDetach()
    {
        $child  = new Thing();
        $parent = new Thing();

        $child->attachTo($parent);

        $this->assertSame($parent, $child->getParent());
        $this->assertContains($child, $parent->getChildren());

        $child->detach();

        $this->assertNull($child->getParent());
        $this->assertNotContains($child, $parent->getChildren());
    }

    /**
     * Test parentship from a parent viewpoint
     * AddChild and RemoveChild updates both sides of the relation.
     */
    public function testAddChildRemoveChild()
    {
        $child  = new Thing();
        $parent = new Thing();

        $parent->addChild($child);

        $this->assertSame($parent, $child->getParent());
        $this->assertContains($child, $parent->getChildren());

        $parent->removeChild($child);

        $this->assertNull($child->getParent());
        $this->assertNotContains($child, $parent->getChildren());
    }

} 