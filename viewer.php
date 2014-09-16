<?php

require_once __DIR__ . '/vendor/autoload.php';

use Forkwars\World\WorldFactory;

// Retrieve a world or create one
if(! file_exists('game.cache') || isset($_GET['reset'])){
    $worldFactory = new WorldFactory();
    $mapString = file_get_contents(__DIR__ . '/data/basic.map');
    $world = $worldFactory->make($mapString);
} else {
    $world = unserialize(file_get_contents('game.cache'));
    $world->day++;
}

// apply some logic on world
$red = new \Forkwars\General\DumbBot();
$red->giveOrders($world);

// Save it !
file_put_contents('game.cache', serialize($world));

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
