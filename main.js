;
(function(document, PIXI){

    var World = function(height, width){
        this.height = height;
        this.width  = width;

        // texture cache
        this.texturesTerrains = new Array();
        this.terrainMap = null;
    }

    World.prototype.init = function(element, terrainMap)
    {
        this.terrainMap = terrainMap;

        // Init PIXI stage
        this.stage = new PIXI.Stage(0x97c56e, true);
        this.renderer = PIXI.autoDetectRenderer(this.width*32*2, this.height*32*2, null);
        element.appendChild( this.renderer.view );

        var that = this;
        requestAnimFrame( function(){
            that.renderer.render(that.stage);
        });

        // Load textures
        loader = new PIXI.AssetLoader([ "sprites.json" ]);
        loader.onComplete = function(){that.onAssetLoaded()};
        loader.load();
    };

    World.prototype.onAssetLoaded = function(){
        var that = this;
        this.terrainMap.forEach(function(t){
            console.log(t);
            that.createTerrain(t[0], t[1], t[2]);
        });
        requestAnimFrame( function(){
            that.renderer.render(that.stage);
        });
    };

    World.prototype.createTerrain = function(code, x, y){
        if(! code){
            return;
        }

        var iconeTerrain = code+".png";

        if(! this.texturesTerrains[iconeTerrain])
        {
            var texture = PIXI.Texture.fromFrame(iconeTerrain);
            this.texturesTerrains[iconeTerrain] = texture;
        }

        var terrain = new PIXI.Sprite(this.texturesTerrains[iconeTerrain]);

        terrain.anchor.x = 1;
        terrain.anchor.y = 1;
        if(code == 'F'){
            terrain.tint = 0xFF0000;
        }
        if(code == 'f'){
            terrain.tint = 0x0000FF;
        }

        //terrain.tint = 0xFFFFFF * Math.random();

        //on prend la taille de l'image agrandi 2 fois car image 16*16 alors qu'on a des zones de 32*32.
        terrain.scale.x = terrain.scale.y = 4; //2 fois pour etre en 32*32 et 2 fois pour l'agrandissement.

        // move the sprite to its designated position
        //on calcule le x par rapport a la matrice de la grille en prenant en compte
        //la taille en px de la zone ainsi que l'échelle car aucun terrain ne dois se chauvaucher.
        terrain.position.x = x*32*2+64;
        terrain.position.y = y*32*2+64;
        terrain.setInteractive(true);
        terrain.click = terrain.clap = function(data){
            console.log(data+" type="+iconeTerrain+" x:"+x+" y:"+y+" width:"+terrain.width+" height:"+terrain.height);
        }
        if(terrain.width > 64){
            scale = 64/terrain.width;
            terrain.scale.x = terrain.scale.y = 4*scale;
        }

        // add it to the stage
        this.stage.addChild(terrain);
    };

    document.World = World;
})(document, PIXI);
