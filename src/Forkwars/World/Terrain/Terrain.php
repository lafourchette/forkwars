<?php

namespace Forkwars\World\Terrain;

use Forkwars\Position;
use Forkwars\World\Thing;

class Terrain extends Thing
{
	public $shelterPower;

    /**
     * @var string $code Terrain code, for string representation
     */
    private $code;

    public function setCode($code)
    {
        $this->code = $code;
    }
}