<?php

namespace Forkwars\World;

use Forkwars\Position;

/**
 * Builds a World
 * @todo needs a set of Teams
 * @package Forkwars\World
 */
class WorldFactory
{
    private $terrainFactory;

    public function __construct(
        TerrainFactory $terrainFactory
    ){
        $this->terrainFactory = $terrainFactory;
    }

    public function make($string)
    {
        $lines = explode(PHP_EOL, $string);

        $name = $lines[0];

        $teamCount = $lines[2]; // shall be integer
        $teams = array();
        for($i=0; $i <= $teamCount; $i++){
            array_push($teams, new Team($i));
        }
        $this->terrainFactory->setAvailableTeams($teams);

        if (! preg_match('/(\d+)x(\d+)/', $lines[1], $matches)) {
            throw new \Exception('Cannot find size info in map file');
        }

        $width  = $matches[1];
        $height = $matches[2];

        $world = new World($name, $width, $height);

        $world->setAvailableTeams($teams);

        for ($y = 0; $y < $height; $y++) {

            $line = $lines[3 + $y];
            for ($x = 0; $x < $width; $x++) {
                $terrain = $this->terrainFactory->make($line[$x]);
                $terrain->setPosition(new Position($x, $y));
                $world->addChild($terrain);
                $world->registerReference($terrain);
            }
        }

        return $world;
    }

}
