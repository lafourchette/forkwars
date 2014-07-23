<?php

require_once __DIR__ . '/vendor/autoload.php';

use Forkwars\General\DumbBot;
use Forkwars\General\NaiveBot;
use Forkwars\World\WorldFactory;

// Create a world
$worldFactory = new WorldFactory();
$mapString = file_get_contents(__DIR__ . '/data/basic.map');
$world = $worldFactory->make($mapString);

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