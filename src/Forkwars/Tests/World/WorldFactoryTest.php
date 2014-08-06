<?php

namespace Forkwars\Tests\World;

use Forkwars\Position;
use Forkwars\World\WorldFactory;
use Forkwars\Tests\ProphecyTestCase;

class WorldFactoryTest extends ProphecyTestCase
{
    // Device Under Test
    private $dut;

    public function setUp()
    {
        parent::setUp();
        $this->dut = new WorldFactory();
        $this->mockTerrainFactory = $this->prophesize('Forkwars\\World\\TerrainFactory');
    }

    public function testMakeOk()
    {
        $map = <<<EOF
yeah
1x1
i
EOF;
        $world = $this->dut->make($map);

        $this->assertInstanceOf('Forkwars\\World\\World', $world);
        $this->assertInstanceOf('Forkwars\\World\\Terrain\\Water', $world->getTerrain(new Position(0, 0)));
    }

    public function testMakeMissingName()
    {
        $world = <<<EOF
1x1
i
EOF;
    }

    public function testMakeWrongSize()
    {
        $world = <<<EOF
101
i
EOF;
    }

    public function testMakeUnknownTerrain()
    {
        $world = <<<EOF
yeah
1x1
@
EOF;
    }
    
    public function testMakeStandardStringFormatOk()
    {
		$map = 'yeah
1x1
x';
		$world = $this->dut->make($map);
		$this->assertInstanceOf('Forkwars\\World\\World', $world);
        	$this->assertInstanceOf('Forkwars\\World\\Terrain\\Land', $world->getTerrain(new Position(0, 0)));
	}
	
	/**
     	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Cannot find size info in map reprensation
     	*/
	public function testMakeWrongWorldFormat()
	{
		$map = 'yeah;1x1;i';
		$world = $this->dut->make($map);
	}
	
	/**
     	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage unknown code
     	*/
	public function testMakeSizeTerrainNoMatch()
	{
		$map = <<<EOF
yeah
1x2
i
EOF;
		$world = $this->dut->make($map);
	}
	
	public function testMakeEmptySizeOk()
	{
		$map = <<<EOF
yeah
0x0
EOF;
		$world = $this->dut->make($map);
	}
	
	public function testMakeNegativeWidthOk()
	{
		$map = <<<EOF
yeah
-1x1
b
EOF;
		$world = $this->dut->make($map);
		$this->assertInstanceOf('Forkwars\\World\\World', $world);
        	$this->assertInstanceOf('Forkwars\\World\\Terrain\\Headquarter', $world->getTerrain(new Position(0, 0)));
	}
	
	public function testMakeTooLargeWidth()
	{
		$map = <<<EOF
yeah
2147483647x1
EOF;
		$world = $this->dut->make($map);
	}
	
	public function testMakeFloatWidthOk()
	{
		$map = <<<EOF
yeah
1.1x1
EOF;
		$world = $this->dut->make($map);
		$this->assertInstanceOf('Forkwars\\World\\World', $world);
        	$this->assertInstanceOf('Forkwars\\World\\Terrain\\Water', $world->getTerrain(new Position(0, 0)));
	}
	
	/**
     	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Cannot find size info in map reprensation
     	*/
	public function testWrongHeight()
	{
		$map = <<<EOF
yeah
1xa
EOF;
		$world = $this->dut->make($map);
	}
	
	/**
     	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Cannot find size info in map reprensation
     	*/
	public function testUnknownSize()
	{
		$map = <<<EOF
yeah

EOF;
		$world = $this->dut->make($map);
	}
}
