<?php

namespace Forkwars\World;

/**
 * A Thing is part of a World, got a position on it, and is sometimes part of a team.
 *
 * Everything is a Thing.
 */
class Thing extends \Forkwars\Scene\Node
{
    private $team = null;

    public function getName(){
        throw new \Exception('please give it a name');
    }

    /**
     * @param null $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return null
     */
    public function getTeam()
    {
        return $this->team;
    }

    public function registerAction(Action $action)
    {
        throw new \Exception('Cannot register action');
    }

    public function registerReference(Thing $thing)
    {
        throw new \Exception('Cannot register reference');
    }
}
