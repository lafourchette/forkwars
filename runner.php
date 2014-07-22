<?php

require_once __DIR__ . '/vendor/autoload.php';

use Forkwars\World\World;
use Forkwars\General\DumbBot;
use Forkwars\General\NaiveBot;
use Forkwars\World\WorldFactory;

// Create a world
$worldFactory = new WorldFactory();
$world = $worldFactory->make(__DIR__ . '/data/basic.map');

var_dump($world); die;
return;

// Some generals
$blue = new DumbBot();
$red = new NaiveBot();

$runner = new \Forkwars\Runner(
    $world,
    $blue,
    $red
);

$runner->run();

echo $runner->getWinner();