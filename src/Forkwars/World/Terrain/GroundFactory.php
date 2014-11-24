<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Unit\Unit;

class Factory extends CapturableTerrain
{
    public function __construct()
    {

    }


    /**
     * @param $unitClass
     */
    public function spawn($unitClass)
    {
        $unit = $this->getTeam()->buy($unitClass);

        $this->getWorld()->spawnUnit($this->getPosition(), $unit);
        $unit->setTeam($this->getTeam());
    }
}
