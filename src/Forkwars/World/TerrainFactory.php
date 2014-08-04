<?php

namespace Forkwars\World;


use Forkwars\World\Terrain\City;
use Forkwars\World\Terrain\Factory;
use Forkwars\World\Terrain\Headquarter;
use Forkwars\World\Terrain\Land;
use Forkwars\World\Terrain\Terrain;
use Forkwars\World\Terrain\SeizableTerrain;
use Forkwars\World\Terrain\Water;

class TerrainFactory
{
    public function make($code, World $world)
    {
        $t = null;
        switch($code)
        {
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
            case 'j': // neutral
                $t = new City();
                break;
            default:
                throw new \Exception('unknown code');
                break;
        }

        if($t instanceof SeizableTerrain){
            $t->setTeam(self::getTeamByCode($code));
        }
        $t->setCode($code);
        $t->setWorld($world);
        return $t;
    }

    public function recycle(Terrain $terrain)
    {

    }
    
    public function getTeamByCode($code){
        $teamCode = 0;
        if(in_array($code, array('R', 'F', 'C'))){
            $teamCode = 1; //red Team;
        }elseif(in_array($code, array('b', 'f', 'c'))){
            $teamCode = 2; //blue Team;
        }
        return $teamCode;
    }
}