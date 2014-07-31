<?php

namespace Forkwars\Tests\Unit;

use Forkwars\Tests\ProphecyTestCase;
use Forkwars\World\Terrain\Land;
use Forkwars\World\World;
use Forkwars\Position;
use Forkwars\World\Unit\Infantry;

// @todo shall maybe become a Unit test
class InfantryTest extends ProphecyTestCase
{
    private $world;

    public function setUp()
    {
        parent::setUp();

        $this->world = new World('test', 3, 3);
        $this->world->fillWith(new Land());
    }

    public function testSpawn()
    {
        $pos = new Position(0,0);
        $infantry = new Infantry();
        $this->world->spawnUnit($pos, $infantry);

        $this->assertSame($this->world->getUnitAt($pos), $infantry);
        return $this->world;
    }

    /**
     * @depends testSpawn
     */
    public function testMoveTo($world)
    {
        $this->world = $world;
        $pos = new Position(1,0);
        $infantry = $this->world->getUnitAt(new Position(0,0));
        $infantry->moveTo($pos);
        $this->assertSame($this->world->getUnitAt($pos), $infantry);
    }
}
