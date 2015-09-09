<?php
use Forkwars\World\Terrain\Terrain;
use Forkwars\Position;

class UnitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testMoveTo()
    {
        $from = new \Forkwars\World\Thing();
        $from->setPosition(new \Forkwars\Position(0, 0));
        $to   = $this->prophesize('Forkwars\World\Thing');
        $toR  = $to->reveal();
        $to->registerAction(\Prophecy\Argument::type('Forkwars\World\Action'))->shouldBeCalled();
        $to->getChildren()->willReturn(new \SplObjectStorage());
        $to->getPosition()->willReturn(new \Forkwars\Position(0, 0));

        // Test
        $dut = new \Forkwars\World\Unit\Unit();
        $dut->setParent($from);
        $dut->moveTo($toR);

        $this->assertSame($toR, $dut->getParent());
    }

    /**
     * Move a Unit across 4 lands. Shall rise an exception somewhere.
     */
    public function testMoveToTooFar()
    {
        $this->setExpectedException('Forkwars\World\Unit\UnitMovementException');

        $from = new Terrain(array('movementCost' => 100)); $from->setPosition(new Position(0, 0));
        $a   = new Terrain(array('movementCost' => 50));  $a->setPosition(new Position(0, 1));
        $b   = new Terrain(array('movementCost' => 100));   $b->setPosition(new Position(0, 2)); // Rise exception here
        $to   = new Terrain(array('movementCost' => 200));  $to->setPosition(new Position(0, 3));

        // Test
        $dut = new \Forkwars\World\Unit\Unit(array("maxMovementByTurn" => 200));
        $dut->setParent($from);
        $dut->moveTo($a);
        $dut->moveTo($b);
        $dut->moveTo($to);
    }
}
