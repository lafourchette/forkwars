<?php

require_once __DIR__ . '/vendor/autoload.php';

use Forkwars\Game;
use Forkwars\World\WorldFactory;
use Forkwars\World\TerrainFactory;
use Forkwars\General\InactiveBot;
use Forkwars\General\NaiveBot;

date_default_timezone_set('UTC');

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
    new \Forkwars\WinCondition\MaxTurn(3)
);

$record = $game->run();
?>
<html>
<head>
    <title>Forkwars viewer</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
</head>
<body>
    <h1>Game viewer</h1>
    <!-- scripts -->
    <script type="text/javascript" src="/pixi.js"></script>
    <script type="text/javascript" src="/main.js"></script>
    <script type="text/javascript">
        (function(World){
            var record = <?php echo $record->toJson(); ?>;
            var world = new World(1, 2);
            world.init(document.body, record.map, []);
            var turn = record.turns[0];
            var action = turn.actions[0];
            console.log(action);
        })(document.World);
    </script>
</body>
</html>

