<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Thing;
use Forkwars\World\Unit\Unit;

class Factory extends Terrain
{
    public function spawn(Unit $unit)
    {
        $this->getWorld()->spawnUnit($this->getWorldPosition(), $unit);
        $unit->setTeam($this->getTeam());
    }
}
