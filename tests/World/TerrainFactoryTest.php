<?php

use Forkwars\World\TerrainFactory;

class TerrainFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testMake()
    {
        $dut = new TerrainFactory(array(array('code' => 'a')));
        $dut->setAvailableTeams(array(0 => new \Forkwars\World\Team(0), 1 => new \Forkwars\World\Team(1)));
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
        $dut->setAvailableTeams(array(0 => new \Forkwars\World\Team(0), 1 => new \Forkwars\World\Team(1)));
        $t = $dut->make('r');
        $this->assertInstanceOf('ForkWars\World\Terrain\Terrain', $t);
        $this->assertInstanceOf('Forkwars\World\Team', $t->getTeam());
    }
}
