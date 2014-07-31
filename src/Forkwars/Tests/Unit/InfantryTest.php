<?php

namespace Forkwars\Tests\Unit;

use Forkwars\Tests\ProphecyTestCase;
use Forkwars\World\Terrain\Land;
use Forkwars\World\World;

class InfantryTest extends ProphecyTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->world = new World('test', 3, 3);
        $this->world->fillWith(new Land());
    }
}
