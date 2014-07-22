<?php

namespace Forkwars\World;

use Forkwars\World\Terrain\Terrain;

/**
 * Holds the world representation
 *
 * @package Forkwars\World
 */
class World
{
    private $name;

    private $width;

    private $height;

    private $terrainMap;

    function __construct($name, $width, $height)
    {
        $this->name = $name;
        $this->width= $width;
        $this->height=$height;
    }

    function setTerrain($x, $y, Terrain $terrain)
    {
        $this->terrainMap[$this->pos($x, $y)] = $terrain;
        return $this;
    }

    private function pos($x, $y)
    {
        return $x + $this->width * $y;
    }
}