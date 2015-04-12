<?php

use Forkwars\World\Thing;
use Forkwars\World\World;

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

    public function testGetRootWillGetTheThing()
    {
        $thing = new World('toto',1,1);
        $this->assertSame($thing, $thing->getRoot());
    }

    public function testGetRootWillGetTheParentThing()
    {
        $parent  = new World('toto',1,1);
        $terrain = new Forkwars\World\Terrain\Terrain(array());
        $child   = new Thing();

        $terrain->addChild($child);
        $parent->addChild($terrain);

        $this->assertSame($parent, $child->getRoot());
    }


    public function testGetRootWillGetTheGrantParentThing()
    {
        $child       = new Thing();
        $parent      = new Thing();
        $grantParent = new World('toto',1,1);
        $terrain = new Forkwars\World\Terrain\Terrain(array());

        $parent->addChild($child);
        $terrain->addChild($parent);
        $grantParent->addChild($terrain);

        $this->assertNotSame($parent, $child->getRoot());
        $this->assertSame($grantParent, $child->getRoot());
    }
}
