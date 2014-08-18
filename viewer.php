<?php

require_once __DIR__ . '/vendor/autoload.php';

use Forkwars\World\WorldFactory;

// Create a world
$worldFactory = new WorldFactory();
$mapString = file_get_contents(__DIR__ . '/data/basic.map');
$world = $worldFactory->make($mapString);
?>
<html>
<head>
    <title>Forkwars viewer</title>
    <link rel="stylesheet" type="text/css" href="/style.css">
</head>
<body>

    <!-- scripts -->
    <script type="text/javascript" src="/pixi.js"></script>
    <script type="text/javascript" src="/main.js"></script>
    <script type="text/javascript">
        (function(World){
            var world = new World(<?= $world->height ?>, <?= $world->width ?>);
            world.init(document.body, [
                <?php for($y = 0; $y < $world->height ; $y++) : for($x = 0; $x < $world->width ; $x++) : ?>
                ['<?php echo $world->getTerrain(new \Forkwars\Position($x, $y))->getCode(); ?>', <?php echo $x; ?>, <?php echo $y; ?>],
                <?php endfor; endfor; ?>
            ]);
        })(document.World);
    </script>
</body>
</html>
