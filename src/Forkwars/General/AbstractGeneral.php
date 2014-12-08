<?php

namespace Forkwars\General;

use Forkwars\World\Team;
use Forkwars\World\World;

abstract class AbstractGeneral implements GeneralInterface
{
    private $team;

    public function __construct(/*Team $team*/)
    {
        //$this->team = $team;
    }

    public function getTeam()
    {
        return $this->team;
    }

    abstract public function doActions(World $world);
}