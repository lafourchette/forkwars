<?php

namespace Forkwars\World;

use Forkwars\Position;
use Forkwars\World\TerrainFactory;
use Forkwars\World\World;

/**
 * Builds a World
 *
 * @package Forkwars\World
 */
class WorldFactory
{
    private $terrainFactory;

    public function __construct()
    {
        $this->terrainFactory = new TerrainFactory();
    }

    public function setTerrainFactory($terrainFactory)
    {
        $this->terrainFactory = $terrainFactory;
    }

    public function make($string)
    {
        //$raw = file_get_contents($mapFile);
        $lines = explode(PHP_EOL, $string);

        $name = $lines[0];
        if(! preg_match('/(\d+)x(\d+)/', $lines[1], $matches)){
            throw new \Exception('Cannot find size info in map reprensation');
        }

        $width = $matches[1];
        $height = $matches[2];

        $world = new World($name, $width, $height);

        for ($y = 0; $y < $height; $y++) {

            $line = $lines[2 + $y];
            for($x = 0; $x < $width; $x++){
                $terrain = $this->terrainFactory->make($line[$x], $world);
                $world->setTerrain(new Position($x, $y), $terrain);
            }
        }

        return $world;
    }

}