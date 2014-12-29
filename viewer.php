<?php

require_once __DIR__ . '/vendor/autoload.php';

use Forkwars\World\WorldFactory;

// Create world
$worldFactory = new WorldFactory();
$world = $worldFactory->make(file_get_contents(__DIR__ . '/data/basic.map'));

$game = new \Forkwars\Game(
    $world,
    new \Forkwars\General\NaiveBot(),
    new \Forkwars\General\DumbBot(),
    new \Forkwars\WinCondition\CapturedHeadquarter()
);

$result = $game->run();

var_dump($result);

exit;
?>
<html>
<head>
    <title>Forkwars viewer</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
</head>
<body>
    <h1>Day <?php echo $world->day; ?></h1>
    <p>Refresh to play the next day</p>
    <a href="/viewer.php?reset=1">Reset the game</a><br />

    <!-- scripts -->
    <script type="text/javascript" src="/pixi.js"></script>
    <script type="text/javascript" src="/main.js"></script>
    <script type="text/javascript">
        (function(World){
            var world = new World(<?= $world->height ?>, <?= $world->width ?>);
            // Draw terrain
            world.init(document.body, [
                <?php for($y = 0; $y < $world->height ; $y++) : for($x = 0; $x < $world->width ; $x++) : ?>
                ['<?php echo $world->getTerrain(new \Forkwars\Position($x, $y))->getCode(); ?>', <?php echo $x; ?>, <?php echo $y; ?>],
                <?php endfor; endfor; ?>
            ],
            [
                <?php foreach($world->getUnits() as $unit) : ?>
                ['<?php echo $unit->getCode(); ?>', <?php echo $unit->getWorldPosition()->x; ?>, <?php echo $unit->getWorldPosition()->y; ?>],
                <?php endforeach; ?>
            ]);
        })(document.World);
    </script>
</body>
</html>
