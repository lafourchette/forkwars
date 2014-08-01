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
<!--
On inclus la librairy pixi.js, possibilité de l'intégrer directement au projet avec un lien relatif'

-->
<script type="text/javascript" src="http://www.goodboydigital.com/pixijs/bunnymark/js/pixi.js"></script>


</head>
<body>

<script type="text/javascript">

    var heightWorld = <?php echo $world->height; ?>;
    var widthWorld = <?php echo $world->width; ?>;
    
    //on stocke les textures des différents terrains pour ne pas les initialiser plus d'une fois (gain de ressources et de temps)
    var texturesTerrains = new Array();
    
    // create an new instance of a pixi stage
	var stage = new PIXI.Stage(0x97c56e, true);
	// create a renderer instance
	var renderer = PIXI.autoDetectRenderer(widthWorld*32*2, heightWorld*32*2, null);
	
	// add the renderer view element to the DOM
	document.body.appendChild(renderer.view);
	renderer.view.style.position = "absolute";
	renderer.view.style.top = "0px";
	renderer.view.style.left = "0px";
	requestAnimFrame( animate );
	
	// create a texture from an image path
    /*
        On parcours la grille des cases pour récupérer le code et appliqué le masque correspondant dans le canvas.
        On pourrais parcourir directement la grille basic.map mais il faudrait réencoder la logique en JS (1er ligne = nom, 2eme dimensions, ligne suivante etc...)

    */

	function onAssetsLoaded() {    
		<?php for($y = 0; $y < $world->height ; $y++) :?>
		
		<?php for($x = 0; $x < $world->width ; $x++) :?>
		
		createTerrain('<?php echo $world->getTerrain(new \Forkwars\Position($x, $y))->getCode(); ?>', <?php echo $x; ?>, <?php echo $y; ?>)
		
		<?php endfor; ?>
		
		<?php endfor; ?>
	}

// create an array of assets to load
	var assetsToLoader = [ "sprites.json"];
	
	// create a new loader
	loader = new PIXI.AssetLoader(assetsToLoader);
	
	// use callback
	loader.onComplete = onAssetsLoaded
	
	//begin load
	loader.load();
	
	

	function createTerrain(code, x, y)
	{
		var iconeTerrain = code+".png";

        if(!texturesTerrains[iconeTerrain])
        {
            var texture = PIXI.Texture.fromFrame(iconeTerrain);
            texturesTerrains[iconeTerrain] = texture;
        }

		var terrain = new PIXI.Sprite(texturesTerrains[iconeTerrain]);

		terrain.anchor.x = 1;
		terrain.anchor.y = 1;
		
		//on prend la taille de l'image agrandi 2 fois car image 16*16 alors qu'on a des zones de 32*32.
		terrain.scale.x = terrain.scale.y = 4; //2 fois pour etre en 32*32 et 2 fois pour l'agrandissement.
		
		// move the sprite to its designated position
        //on calcule le x par rapport a la matrice de la grille en prenant en compte
        //la taille en px de la zone ainsi que l'échelle car aucun terrain ne dois se chauvaucher.
		terrain.position.x = x*32*2+64;
		terrain.position.y = y*32*2+64;
		// add it to the stage
		stage.addChild(terrain);
	}
	
	function animate() {
	
	    requestAnimFrame( animate );
	
	    renderer.render(stage);
	}



</script>

</body>
</html>
