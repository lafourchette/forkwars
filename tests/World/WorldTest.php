<?php

class WorldTest extends \PHPUnit_Framework_TestCase
{
    // Device Under Test
    private $dut;

    private $ter1, $ter2;

    public function setUp()
    {
        parent::setUp();

        $this->dut = new \Forkwars\World\World('test', 4, 4);
        $this->ter1 = new \Forkwars\World\Terrain\Terrain(array("movementCost" => 100,"name" => "ter1"));
        $this->ter2 = new \Forkwars\World\Terrain\Terrain(array("movementCost" => 100, "name" => "ter2"));

        $this->ter_bottom_left = new \Forkwars\World\Terrain\Terrain(array("movementCost" => 100,"name" => "ter_bottom_left"));
        $this->ter_bottom_right = new \Forkwars\World\Terrain\Terrain(array("movementCost" => 100, "name" => "ter_bottom_right"));
        $this->ter_upper_left = new \Forkwars\World\Terrain\Terrain(array("movementCost" => 100,"name" => "ter_upper_left"));
        $this->ter_upper_right = new \Forkwars\World\Terrain\Terrain(array("movementCost" => 100, "name" => "ter_upper_right"));
        $this->ter_middle = new \Forkwars\World\Terrain\Terrain(array("movementCost" => 100, "name" => "ter_middle"));

        $this->ter1->setPosition(new \Forkwars\Position(0,0))->attachTo($this->dut);
        $this->ter2->setPosition(new \Forkwars\Position(1,0))->attachTo($this->dut);

        $this->ter_bottom_left->setPosition(new \Forkwars\Position(0,0))->attachTo($this->dut);
        $this->ter_bottom_right->setPosition(new \Forkwars\Position(3,0))->attachTo($this->dut);
        $this->ter_upper_left->setPosition(new \Forkwars\Position(0,3))->attachTo($this->dut);
        $this->ter_upper_right->setPosition(new \Forkwars\Position(3,3))->attachTo($this->dut);
        $this->ter_middle->setPosition(new \Forkwars\Position(1,1))->attachTo($this->dut);
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

    public function testNeighborPositions()
    {
      // Test bottom left
      $neighbors = $this->dut->getNeighboringPositions($this->ter_bottom_left->getPosition());
      $count_neighbors = count($neighbors);
      $this->assertEquals($count_neighbors,2);
      foreach($neighbors as $neighbor) {
        if(($neighbor->x == 0 && $neighbor->y == 1) || ($neighbor->x == 1 && $neighbor->y == 0)) {
          $count_neighbors--;
        }
      }
      $this->assertEquals($count_neighbors,0);

      // Test bottom right
      $neighbors = $this->dut->getNeighboringPositions($this->ter_bottom_right->getPosition());
      $count_neighbors = count($neighbors);
      $this->assertEquals($count_neighbors,2);
      foreach($neighbors as $neighbor) {
        if(($neighbor->x == 3 && $neighbor->y == 1) || ($neighbor->x == 2 && $neighbor->y == 0)) {
          $count_neighbors--;
        }
      }
      $this->assertEquals($count_neighbors,0);

      // Test upper left
      $neighbors = $this->dut->getNeighboringPositions($this->ter_upper_left->getPosition());
      $count_neighbors = count($neighbors);
      $this->assertEquals($count_neighbors,2);
      foreach($neighbors as $neighbor) {
        if(($neighbor->x == 1 && $neighbor->y == 3) || ($neighbor->x == 0 && $neighbor->y == 2)) {
          $count_neighbors--;
        }
      }
      $this->assertEquals($count_neighbors,0);

      // Test upper right
      $neighbors = $this->dut->getNeighboringPositions($this->ter_upper_right->getPosition());
      $count_neighbors = count($neighbors);
      $this->assertEquals($count_neighbors,2);
      foreach($neighbors as $neighbor) {
        if(($neighbor->x == 2 && $neighbor->y == 3) || ($neighbor->x == 3 && $neighbor->y == 2)) {
          $count_neighbors--;
        }
      }
      $this->assertEquals($count_neighbors,0);

      // Test Middle
      $neighbors = $this->dut->getNeighboringPositions($this->ter_middle->getPosition());
      $count_neighbors = count($neighbors);
      $this->assertEquals($count_neighbors,4);
      foreach($neighbors as $neighbor) {
        if(($neighbor->x == 0 && $neighbor->y == 1) || ($neighbor->x == 2 && $neighbor->y == 1)
         || ($neighbor->x == 1 && $neighbor->y == 0) || ($neighbor->x == 1 && $neighbor->y == 2)) {
          $count_neighbors--;
        }
      }
      $this->assertEquals($count_neighbors,0);

    }


}
