<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Forkwars\Game;
use Forkwars\World\WorldFactory;
use Forkwars\World\TerrainFactory;
use Forkwars\General\InactiveBot;
use Forkwars\General\NaiveBot;

date_default_timezone_set('UTC');

// Init the factories
$terrainFactory = new TerrainFactory(json_decode(
    file_get_contents(__DIR__ . '/../data/terrains.json'),true
));
$worldFactory = new WorldFactory($terrainFactory);

// Create world
$world = $worldFactory->make(file_get_contents(__DIR__ . '/../data/island.map'));

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
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/pixi.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
    <script type="text/javascript">
        (function(World, $){
            var record = <?php echo $record->toJson(); ?>;
            var world = new World(11, 8);

            var currentIndex = 0; // current index is already played
            function playRecord(index) {
                if(index == currentIndex){
                    return;
                }
                if(index > currentIndex){
                    // forward
                    for(var i = ++currentIndex; i <= index; i++){
                        world.doAction(actionList[i]);
                    }
                } else {
                    // backward
                    for(var i = currentIndex; i > index; i--){
                        world.undoAction(actionList[i]);
                    }
                }
                currentIndex = index;
            }

            // Create a list of actions with references
            var actionList = [];
            record.turns.forEach(function(turn){
                turn.actions.forEach(function(action){
                    actionList.push(action);
                    var idx = actionList.length - 1;
                    var liItem = $('<tr><td>'+(idx)+'</td><td>'+action.summary+'</td></tr>')
                    $('.actionList').append(liItem);

                    liItem.click(function(){
                        $('.actionList').find('tr').removeClass('active');
                        playRecord(idx);
                        liItem.addClass('active');
                    });
                });
            });

            world.init($('.map')[0], record.map, function(world){
                world.doAction(record.turns[0].actions[0]);
            });

        })(document.World, jQuery);
    </script>
</body>
</html>

