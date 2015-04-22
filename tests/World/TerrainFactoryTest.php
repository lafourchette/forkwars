<?php

use Forkwars\World\TerrainFactory;
use Forkwars\General\GeneralInterface;
use Forkwars\World\Team;

class TerrainFactoryTest extends \ProphecyTestCase
{
    private $availableTeams;

    public function setUp()
    {
        parent::setUp();

        $this->availableTeams = array(
            Team::TEAM_NONE => new Team(GeneralInterface::NONE),
            Team::TEAM_BLUE => new Team(GeneralInterface::BLUE),
            Team::TEAM_RED  => new Team(GeneralInterface::RED)
        );
    }

    public function testMake()
    {
        $dut = new TerrainFactory(array(new \Forkwars\World\Terrain\Metadata('code', 'a')));
        $dut->setAvailableTeams($this->availableTeams);
        $this->assertInstanceOf('ForkWars\World\Terrain\Terrain', $dut->make('a'));
    }

    public function testMakeUnknownTerrain()
    {
        $this->setExpectedException('Forkwars\Exception\TerrainException');
        $dut = new TerrainFactory(array());
        $dut->setAvailableTeams($this->availableTeams);
        $this->assertInstanceOf('ForkWars\World\Terrain\Terrain', $dut->make('a'));
    }

    public function testMakeTeamTerrain()
    {
        $dut = new TerrainFactory(array(
            new \Forkwars\World\Terrain\Metadata('code', 'a'),
            new \Forkwars\World\Terrain\Metadata('redCode', 'r')
        ));
        $dut->setAvailableTeams($this->availableTeams);
        $t = $dut->make('r');
        $this->assertInstanceOf('ForkWars\World\Terrain\Terrain', $t);
        $this->assertSame(\Forkwars\General\GeneralInterface::RED, (string)$t->getTeam());
    }
}
