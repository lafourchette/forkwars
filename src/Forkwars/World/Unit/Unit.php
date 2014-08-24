<?php

namespace Forkwars\World\Unit;

use Forkwars\World\Terrain\Terrain;
use Forkwars\World\Thing;

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
        return $this->getWorldPosition()->equals($terrain->getWorldPosition());
    }

    /**
     * @var string $code Terrain code, for string representation
     */
    protected $code;

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }
}
