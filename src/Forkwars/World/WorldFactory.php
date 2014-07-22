<?php

namespace Forkwars\World;

use Forkwars\World\Terrain\TerrainFactory;
use Forkwars\World\World;

/**
 * Builds a World with a text representation
 * @package Forkwars\World
 */
class WorldFactory
{
    private $terrainFactory;

    public function __construct()
    {
        $this->terrainFactory = new TerrainFactory();
        $this->terrainFactory->loadAvailableTerrains();
    }

    public function make($mapFile)
    {
        $raw = file_get_contents($mapFile);
        $lines = explode(PHP_EOL, $raw);

        $name = $lines[0];
        if(! preg_match('/(\d+)x(\d+)/', $lines[1], $matches)){
            throw new \Excepiton('Cannot find size info in ' . $mapFile);
        }

        $width = $matches[1];
        $height = $matches[2];

        $world = new World($name, $width, $height);

        for ($y = 0; $y < $height; $y++) {
            $line = $lines[2 + $y];
            for($x = 0; $x < $width; $x++){
                $terrain = $this->terrainFactory->make($line[$x]);
                $world->setTerrain($x, $y, $terrain);
            }
        }

        return $world;
    }

}