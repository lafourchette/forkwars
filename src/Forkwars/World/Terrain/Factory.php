<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Unit\Unit;

class Factory extends CapturableTerrain
{
    public function spawn(Unit $unit)
    {
        $this->getWorld()->spawnUnit($this->getWorldPosition(), $unit);
        $unit->setTeam($this->getTeam());
    }
}
