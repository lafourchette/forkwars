<?php

use Forkwars\World\TerrainFactory;

class TerrainFactoryTest extends \ProphecyTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testMake()
    {
        $dut = new TerrainFactory(array(array('code' => 'a')));
        $this->assertInstanceOf('ForkWars\World\Terrain\Terrain', $dut->make('a'));
    }

    public function testMakeUnknownTerrain()
    {
        $this->setExpectedException('Forkwars\Exception\TerrainException');
        $dut = new TerrainFactory(array());
        $this->assertInstanceOf('ForkWars\World\Terrain\Terrain', $dut->make('a'));
    }

    /**
     * @todo dep against getTeam
     */
    public function testMakeTeamTerrain()
    {
        $dut = new TerrainFactory(array(array('code' => 'a', 'redCode' => 'r')));
        $t = $dut->make('r');
        $this->assertInstanceOf('ForkWars\World\Terrain\Terrain', $t);
        $this->assertSame(\Forkwars\General\GeneralInterface::RED, $t->getTeam());
    }
}
