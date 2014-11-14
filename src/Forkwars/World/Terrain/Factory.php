<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Unit\Unit;

class Factory extends CapturableTerrain
{
    /**
     * @param $unitClass
     */
    public function spawn($unitClass)
    {
        $this->


        $this->getWorld()->spawnUnit($this->getPosition(), $unit);
        $unit->setTeam($this->getTeam());
    }
}
