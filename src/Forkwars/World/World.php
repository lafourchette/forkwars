<?php

namespace Forkwars\World;

use Forkwars\World\Terrain\Terrain;
use Forkwars\Position;

/**
 * Holds the world representation
 *
 * @package Forkwars\World
 */
class World
{
    private $name;

    public $width;

    public $height;

    private $terrainMap;

    function __construct($name, $width, $height)
    {
        $this->name = $name;
        $this->width= $width;
        $this->height=$height;
    }

    function setTerrain(Position $position, Terrain $terrain)
    {
        $this->terrainMap[$this->pos($position)] = $terrain;
        $terrain->setWorldPosition($position);
        return $this;
    }

    function getTerrain($position)
    {
        return $this->terrainMap[$this->pos($position)];
    }

    private function pos($x, $y = null)
    {
        if($x instanceof Position){
            $y = $x->y;
            $x = $x->x;
        } else if(is_null($y)) {
            throw new \Exception('Please set y');
        }
        return $x + $this->width * $y;
    }
}