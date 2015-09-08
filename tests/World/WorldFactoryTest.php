<?php

use Forkwars\Position;
use Forkwars\World\WorldFactory;

class WorldFactoryTest extends \PHPUnit_Framework_TestCase
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
        $this->mockTerrainFactory->make('i')->willReturn(new \Forkwars\World\Terrain\Terrain(array('name' => 'yay')));
        $this->mockTerrainFactory->setAvailableTeams(\Prophecy\Argument::any())->willReturn(null);
        $map = <<<EOF
yeah
1x1
1
i
EOF;
        $world = $this->dut->make($map);
        $this->assertInstanceOf('Forkwars\\World\\World', $world);
        $this->assertCount(1, $world->getChildren());
    }
}
