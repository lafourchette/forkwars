<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Terrain\Terrain;

class SeizableTerrain extends Terrain
{

    /**
     * @var string $team Team attribution code (1=>red, 2=>blue, 3=>yellow, 4=>green, 0=>neutral), for string representation
     */
    private $team;

    public function setTeam($team)
    {
        $this->team = $team;
    }

    public function getTeam()
    {
        return $this->team;
    }
}