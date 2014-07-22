<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Thing;

class Terrain extends Thing
{
	public $shelterPower;

    static function getCode()
    {
        throw new \Exception('Does not have a terrain code');
    }
}