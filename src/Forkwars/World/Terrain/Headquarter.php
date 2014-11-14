<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Unit\Unit;

class Headquarter extends CapturableTerrain
{
    public $team = Unit::TEAM_BLUE;
}
