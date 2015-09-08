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
        $this->ter1 = new \Forkwars\World\Terrain\Terrain(array("movementCost" => 100,"name" => "ter1"));
        $this->ter2 = new \Forkwars\World\Terrain\Terrain(array("movementCost" => 100, "name" => "ter2"));

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
        $this->assertInstanceOf('Forkwars\Game\Turn', $turn);
        $this->assertCount(1, $turn);
    }

    public function testResetMovementLeftOnTurn()
    {
      $this->dut->startTurn();

      $unit = new \Forkwars\World\Unit\Unit();
      $this->ter1->addChild($unit);
      $unit->moveTo($this->ter2);
      $unit->moveTo($this->ter1);
      $this->assertEquals($unit->getMovementLeft(),0);

      $turn = $this->dut->endTurn();
      $this->dut->startTurn();
      $this->assertEquals($unit->getMovementLeft(),200);

    }
}
