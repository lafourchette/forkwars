<?php

namespace Forkwars\World;

use Forkwars\Position;

/**
 * Most basic type of thing in the game.
 *
 * A thing is part of a world, got a position on it, and which is sometimes part of a team.
 */
class Thing
{
    /**
     * @var World Which world it is part of.
     */
    private $world;

    /**
     * @var Position Where this thing is on the world.
     */
    private $position;

    const TEAM_RED     = 0;
    const TEAM_BLUE    = 1;
    const TEAM_NONE    = 2;

    private $team;

    /**
     * @param World $world
     */
    public function setWorld(World $world)
    {
        $this->world = $world;
    }

    /**
     * @return World
     */
    public function getWorld()
    {
        return $this->world;
    }

    /**
     * @param Position $position
     * @return $this
     */
    public function setWorldPosition(Position $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Position
     */
    public function getWorldPosition()
    {
        return $this->position;
    }

    /**
     * @param int $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @return int
     */
    public function getTeam()
    {
        return $this->team;
    }
}
