<?php

class UnitTest extends \ProphecyTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testMoveTo()
    {
        $this->setExpectedException('\Exception', 'This thing has no position');

        $from = new \Forkwars\World\Thing();
        $to   = $this->prophesize('Forkwars\World\Thing');
        $toR  = $to->reveal();

        $to->getChildren()->willReturn(new \SplObjectStorage());

        // Test
        $dut = new \Forkwars\World\Unit\Unit();
        $dut->setParent($from);
        $dut->moveTo($toR);

        $this->assertSame($toR, $dut->getParent());
    }
}