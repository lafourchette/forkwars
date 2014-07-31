<?php

namespace Forkwars\World\Unit;

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
}
