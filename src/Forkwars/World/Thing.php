<?php

namespace Forkwars\World;

use Forkwars\Position;

/**
 * Most basic type of thing in the game.
 */
class Thing
{

    const TEAM_RED     = 0;
    const TEAM_BLUE    = 1;
    const TEAM_NONE    = 2;

    public $team;

    private $world;

    public function setWorld($world)
    {
        $this->world = $world;
    }

    public function getWorld()
    {
        return $this->world;
    }

    private $position;

    public function setWorldPosition(Position $position)
    {
        $this->position = $position;

        return $this;
    }

    public function getWorldPosition()
    {
        return $this->position;
    }
}
