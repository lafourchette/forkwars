<?php

namespace Forkwars\World;

use Forkwars\World\Terrain\City;
use Forkwars\World\Terrain\Factory;
use Forkwars\World\Terrain\Headquarter;
use Forkwars\World\Terrain\Land;
use Forkwars\World\Terrain\Terrain;
use Forkwars\World\Terrain\Water;

class TerrainFactory
{
    public function make($code, World $world)
    {
        $t = null;
        switch ($code) {
            case 'x':
                $t = new Land();
                break;
            case 'i':
                $t = new Water();
                break;
            case 'R':
            case 'b':
                $t = new Headquarter();
                break;
            case 'F':
            case 'f':
            case 'a': // neutral
                $t = new Factory();
                break;
            case 'C':
            case 'c':
            case 'i': // neutral
                $t = new City();
            default:
                throw new \Exception('unknown code');
                break;
        }

        $t->setCode($code);
        $t->setWorld($world);

        return $t;
    }

    public function recycle(Terrain $terrain)
    {

    }
}
