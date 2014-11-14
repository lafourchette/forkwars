<?php

namespace Forkwars\World\Unit;

use Forkwars\Position;
use Forkwars\World\Action;
use Forkwars\World\Terrain\Terrain;
use Forkwars\World\Thing;

/**
 * Something that can move. Always part of a team.
 */
class Unit extends Thing
{
    public $health;

    public $ammo;

    public $moveCount;

    public $viewCount;

    public $offensePower;

    public $defensePower;

    public $isMarine;

    public $isGround;

    public $isAir;

    public function isAt(Terrain $terrain) {
        return $this->getPosition()->equals($terrain->getPosition());
    }

    /**
     * @param Position $position
     * @return Action
     */
    public function moveTo(Position $position)
    {

    }
}
