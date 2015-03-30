<?php

//@todo should be elsewhere, thats game logic
namespace Forkwars\World;

class Team
{
    const TEAM_NONE = 0;
    const TEAM_RED  = 1;
    const TEAM_BLUE = 2;

    private $teamCode;

    public function __construct($teamCode)
    {
        $this->teamCode = $teamCode;
    }

    public function __toString()
    {
        //var_dump($this->teamCode);
        return (string) $this->teamCode;
    }
} 