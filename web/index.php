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
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <style>
        .actionList {
            height: 200px;
            overflow: scroll;
        }
        .map {
            border: 1px solid grey;
            background: lightgrey;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Game viewer</h1>
    <h5>map</h5>
    <div class="map"></div>
    <h5>actions list</h5>
    <table class="table table-condensed"><tbody class="actionList"></tbody></table>
    </div>

    <!-- scripts -->
    <script type="text/javascript" src="/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/pixi.js"></script>
    <script type="text/javascript" src="/main.js"></script>
    <script type="text/javascript">
        (function(World, $){
            var record = <?php echo $record->toJson(); ?>;
            var world = new World(1, 2);

            // Create a list of actions with references
            var actionList = [];
            record.turns.forEach(function(turn){
                turn.actions.forEach(function(action){
                    actionList.push(action);
                    var currentIndex = actionList.length - 1;
                    var liItem = $('<tr><td>'+(currentIndex+1)+'</td><td>'+action.summary+'</td></tr>')
                    $('.actionList').append(liItem);

                    liItem.click(function(){
                        world.playAction(actionList[currentIndex]);
                    });
                });
            });

            world.init($('.map')[0], record.map, function(world){
                world.playAction(record.turns[0].actions[0]);
            });

        })(document.World, jQuery);
    </script>
</body>
</html>

