<?php

use Forkwars\Position;
use Forkwars\World\WorldFactory;

class WorldFactoryTest extends \ProphecyTestCase
{
    // Device Under Test
    private $dut;

    public function setUp()
    {
        parent::setUp();
        $this->mockTerrainFactory = $this->prophesize('Forkwars\\World\\TerrainFactory');
        $this->dut = new WorldFactory($this->mockTerrainFactory->reveal());
    }

    public function testMake()
    {
        $this->mockTerrainFactory->make('i')->willReturn(new \Forkwars\World\Terrain\Terrain(array()));

        $map = <<<EOF
yeah
1x1
i
EOF;
        $world = $this->dut->make($map);
        $this->assertInstanceOf('Forkwars\\World\\World', $world);
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
}
