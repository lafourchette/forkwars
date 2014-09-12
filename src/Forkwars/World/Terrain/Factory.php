<?php

namespace Forkwars\World\CapturableTerrain;

use Forkwars\World\Thing;
use Forkwars\World\Unit\Unit;

class Factory extends CapturableTerrain
{
    public function spawn(Unit $unit)
    {
        $this->getWorld()->spawnUnit($this->getWorldPosition(), $unit);
        $unit->setTeam($this->getTeam());
    }
}
