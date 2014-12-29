;
(function(document, PIXI){

    // Gives the general world scale
    var scale = 2;

    var World = function(height, width){
        this.height = height;
        this.width  = width;

        // texture cache
        this.texturesTerrains = new Array();
    }

    World.prototype.init = function(element, terrainMap, unitList)
    {
        this.terrainMap = terrainMap;
        this.unitList = unitList;

        // Init PIXI stage
        this.stage = new PIXI.Stage(0x97c56e, true);
        this.renderer = PIXI.autoDetectRenderer(this.width*16*scale, this.height*16*scale, null);
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
            that.createTerrain(t.code, t.x, t.y);
        });
        requestAnimFrame( function(){
            that.renderer.render(that.stage);
        });
    };

    World.prototype.createTerrain = function(code, x, y) {
        if(! code){
            return;
        }

        // Cache texture
        if(! this.texturesTerrains[code]) {
            this.texturesTerrains[code] = PIXI.Texture.fromFrame(code);
        }

        var terrain = new PIXI.Sprite(this.texturesTerrains[code]);
        terrain.anchor.x = terrain.anchor.y = 1;
        terrain.scale.x = terrain.scale.y = scale;
        // Position is +1 because of axis orientation
        terrain.position.x = (x+1)*16*scale;
        terrain.position.y = (y+1)*16*scale;

        /*
        terrain.setInteractive(true);
        terrain.click = terrain.clap = function(data){
            console.log(data+" type="+iconeTerrain+" x:"+x+" y:"+y+" width:"+terrain.width+" height:"+terrain.height);
        }
        */

        // add it to the stage
        this.stage.addChild(terrain);
    };

    document.World = World;
})(document, PIXI);
