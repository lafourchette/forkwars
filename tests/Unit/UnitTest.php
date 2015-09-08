<?php

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
}
