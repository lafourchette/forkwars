<?php

namespace Forkwars\Tests\Algorithm;

use Forkwars\Position;
use Forkwars\Tests\ProphecyTestCase;
use Forkwars\World\Algorithm\ReachablePositionsAlgorithm;
use Forkwars\World\Terrain\Land;
use Forkwars\World\Unit\Infantry;
use Forkwars\World\World;

class ReachablePositionsAlgorithmTest extends ProphecyTestCase
{
    private $world;

    private $unit;

    private $dut;

    public function setUp()
    {
        parent::setUp();

        $this->unit = new Infantry();

        $this->world = new World('test', 10, 10);
        $this->world->fillWith(new Land());
        $this->world->spawnUnit(new Position(5,5), $this->unit);

        $this->dut = new ReachablePositionsAlgorithm();
    }

    public function testOnlyLand()
    {
        $positions = $this->dut->compute($this->unit);
        var_dump($positions);
    }
}
