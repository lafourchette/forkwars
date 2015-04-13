<?php
/**
 * Created by PhpStorm.
 * User: virhi
 * Date: 13/04/15
 * Time: 21:37
 */

use Forkwars\World\TerrainFactory;
use Forkwars\General\GeneralInterface;
use Forkwars\World\Team;
use \Forkwars\World\Terrain\Metadata as TerrainMetadata;
use \Forkwars\World\Unit\Metadata as UnitMetadata;

class FactoryTest extends \ProphecyTestCase
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

    public function testMakeWillReturnUnit()
    {
        $dut = new TerrainFactory(array(
            new TerrainMetadata('code', 'a', 'Factory'),
            new TerrainMetadata('redCode', 'r'),
        ));

        $dut->setAvailableTeams($this->availableTeams);
        $factory  = $dut->make('a');

        $parent   = new \Forkwars\World\World('toto',1,1);
        $parent->setPosition(new \Forkwars\Position(1,1));

        $thing   = new \Forkwars\World\Thing();
        $thing->setPosition(new \Forkwars\Position(1,1));

        $metadata = new UnitMetadata(
            $parent,
            $thing
        );

        $actual   = $factory->make($metadata);
        $this->assertInstanceOf('Forkwars\World\Unit\Unit', $actual);
    }
}