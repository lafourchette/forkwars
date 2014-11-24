<?php

namespace Forkwars\World;

use Forkwars\Position;

/**
 * A thing is part of a World, got a position on it, and which is sometimes part of a team.
 *
 * Everything is a Thing.
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

    public function __construct(World $world, Position $position, Team $team)
    {

    }

    /**
     * @return World
     */
    public function getWorld()
    {
        return $this->world;
    }

    /**
     * @return Position
     */
    public function getPosition()
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
