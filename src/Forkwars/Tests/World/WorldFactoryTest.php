<?php

namespace Forkwars\Tests\World;

use Forkwars\Position;
use Forkwars\World\WorldFactory;
use Forkwars\Tests\ProphecyTestCase;

class WorldFactoryTest extends ProphecyTestCase
{
    // Device Under Test
    private $dut;

    public function setUp()
    {
        parent::setUp();
        $this->dut = new WorldFactory();
        $this->mockTerrainFactory = $this->prophesize('Forkwars\\World\\TerrainFactory');
    }

    public function testMakeOk()
    {
        $map = <<<EOF
yeah
1x1
i
EOF;
        $world = $this->dut->make($map);

        $this->assertInstanceOf('Forkwars\\World\\World', $world);
        $this->assertInstanceOf('Forkwars\\World\\Terrain\\Water', $world->getTerrain(new Position(0, 0)));
    }

    public function testMakeMissingName()
    {
        $world = <<<EOF
1x1
i
EOF;
    }

    public function testMakeWrongSize()
    {
        $world = <<<EOF
101
i
EOF;
    }

    public function testMakeUnknownTerrain()
    {
        $world = <<<EOF
yeah
1x1
@
EOF;
    }
}
