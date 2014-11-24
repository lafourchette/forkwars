<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Thing;

class Terrain extends Thing
{
    public $shelterPower;

    public $footCost  = null;

    public $tyreCost  = null;

    public $trackCost = null;

    /**
     * @var string $code Terrain code, for string representation
     */
    private $code;

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function canHeal()
    {
        return $this->metadata['healing'];
    }

    public function heal()
    {
        // canHeal or throw ImpossibleActionException
        // getChild
        // if has a child, heal it.
    }
}
