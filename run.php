<?php

require_once __DIR__ . '/vendor/autoload.php';

use Forkwars\Game;
use Forkwars\World\WorldFactory;
use Forkwars\World\TerrainFactory;
use Forkwars\General\InactiveBot;
use Forkwars\General\NaiveBot;

// Init the factories
$terrainFactory = new TerrainFactory(json_decode(
    file_get_contents(__DIR__ . '/data/terrains.json'),true
));
$worldFactory = new WorldFactory($terrainFactory);

// Create world
$world = $worldFactory->make(file_get_contents(__DIR__ . '/data/basic.map'));

// New Game
$game = new Game(
    $world,
    new NaiveBot(),
    new InactiveBot(),
    new \Forkwars\WinCondition\MaxTurn(5)
);

$record = $game->run();

echo $record->toString();
