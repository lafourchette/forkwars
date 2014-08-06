;
(function(document){

    var World = function(height, width){
        this.height = height;
        this.width  = width;
    }

    World.prototype.init = function(){
        //on stocke les textures des différents terrains pour ne pas les initialiser plus d'une fois (gain de ressources et de temps)
        var texturesTerrains = new Array();

        // create an new instance of a pixi stage
        var stage = new PIXI.Stage(0x97c56e, true);
        // create a renderer instance
        var renderer = PIXI.autoDetectRenderer(this.width*32*2, this.height*32*2, null);

        document.body.appendChild(renderer.view);
        renderer.view.style.position = "absolute";
        renderer.view.style.top = "0px";
        renderer.view.style.left = "0px";
        requestAnimFrame( animate );

        // create an array of assets to load
        var assetsToLoader = [ "sprites.json"];

        // create a new loader
        loader = new PIXI.AssetLoader(assetsToLoader);

        // use callback
        loader.onComplete = onAssetsLoaded

        //begin load
        loader.load();
    };

    World.prototype.onAssetLoaded = function(){

    };

    World.prototype.animate = function(){
        requestAnimFrame( animate );
        renderer.render(stage);
    };

    World.prototype.createTerrain = function(x, y){
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
        terrain.setInteractive(true);
        terrain.click = terrain.clap = function(data){
            alert(data+" type="+iconeTerrain+" x:"+x+" y:"+y+" width:"+terrain.width+" height:"+terrain.height);
        }
        if(terrain.width > 64){
            scale = 64/terrain.width;
            terrain.scale.x = terrain.scale.y = 4*scale;
        }

        // add it to the stage
        stage.addChild(terrain);
    };

    document.World = World;
})(document);
