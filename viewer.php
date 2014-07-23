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
<style>
.r:after {
    content: ".";
    display: block;
    clear: both;
    visibility: hidden;
    line-height: 0;
    height: 0;
}

.r {
    display: block;
}
.t
{
    width: 32px;
    height: 32px;
    display: block;
    background: url("data/sprites.png") no-repeat;
    background-size: 1410px 768px;
    margin: 0;
    padding: 0;
    float: left;
}
.t.i{background-position: -828px -614px; }
.t.x{background-position: -880px -614px; }
</style>
</head>
<body>

<?php for($y = 0; $y < $world->height; $y++) :?>
    <div class="r">
<?php for($x = 0; $x < $world->width; $x++) :?>

    <div class="t <?php echo $world->getTerrain(new \Forkwars\Position($x, $y))->getCode(); ?>"></div>

<?php endfor; ?>
    </div>
<?php endfor; ?>

</body>
</html>