<?php

use Forkwars\Position;
use Forkwars\World\Algorithm\ReachablePositionsAlgorithm;
use Forkwars\World\Terrain\Land;
use Forkwars\World\Unit\Unit;
use Forkwars\World\World;

class ReachablePositionsAlgorithmTest extends \ProphecyTestCase
{
    private $world;

    private $unit;

    private $dut;

    public function setUp()
    {

        parent::setUp();

        $this->markTestSkipped('please work on refacto');

        $this->unit = new Unit();
        $this->unit->moveCount = 1;

        $this->world = new World('test', 3, 3);
        $this->world->fillWith(new Land());
        $this->world->spawnUnit(new Position(1, 1), $this->unit);

        $this->dut = new ReachablePositionsAlgorithm();
    }

    public function testOnlyLand()
    {
        $positions = $this->dut->compute($this->unit);
        $this->assertCount(5, $positions);
    }
}
