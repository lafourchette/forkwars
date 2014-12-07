<?php

class UnitTest extends \ProphecyTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testMove()
    {
        $from = new \Forkwars\World\Thing();
        $to   = $this->prophesize('Forkwars\World\Thing');
        $toR  = $to->reveal();
        $to->registerAction(\Prophecy\Argument::type('Forkwars\World\Action'))->shouldBeCalled();
        $to->addChild(\Prophecy\Argument::any())->shouldBeCalled();

        // Test
        $dut = new \Forkwars\World\Unit\Unit();
        $dut->setParent($from);
        $dut->moveTo($toR);

        $this->assertSame($toR, $dut->getParent());
    }
}