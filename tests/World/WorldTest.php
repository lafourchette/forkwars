<?php

class WorldTest extends \PHPUnit_Framework_TestCase
{
    // Device Under Test
    private $dut;

    private $ter1, $ter2;

    public function setUp()
    {
        parent::setUp();

        $this->dut = new \Forkwars\World\World('test', 2, 1);
        $this->ter1 = new \Forkwars\World\Terrain\Terrain(array());
        $this->ter2 = new \Forkwars\World\Terrain\Terrain(array());

        $this->ter1->setPosition(new \Forkwars\Position(0,0))->attachTo($this->dut);
        $this->ter2->setPosition(new \Forkwars\Position(1,0))->attachTo($this->dut);
    }

    public function testRegisterActionNoTurn()
    {
        $this->setExpectedException('Forkwars\Exception\GameException');
        $unit = new \Forkwars\World\Unit\Unit();
        $this->ter1->addChild($unit);
        $unit->moveTo($this->ter2);
    }

    public function testRegisterActionTurn()
    {
        $this->dut->startTurn();

        $unit = new \Forkwars\World\Unit\Unit();
        $this->ter1->addChild($unit);
        $unit->moveTo($this->ter2);

        $turn = $this->dut->endTurn();
        $this->assertInstanceOf('Forkwars\World\Game\Turn', $turn);
        $this->assertCount(1, $turn);
    }
}
