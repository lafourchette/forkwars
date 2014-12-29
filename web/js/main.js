;
(function(document, PIXI){

    // Gives the general world scale
    var scale = 2;

    var World = function(height, width){
        this.height = height;
        this.width  = width;

        // texture cache
        this.texturesTerrains = new Array();
        // references
        this.referencesMap =  new Array();
    }

    World.prototype.init = function(element, terrainMap, callback)
    {
        this.terrainMap = terrainMap;

        // Init PIXI stage
        this.stage = new PIXI.Stage(0x97c56e, true);
        this.renderer = PIXI.autoDetectRenderer(this.width*16*scale, this.height*16*scale, null);
        element.appendChild( this.renderer.view );

        var that = this;
        requestAnimFrame( function(){
            that.renderer.render(that.stage);
        });

        // Load textures
        loader = new PIXI.AssetLoader([ "/img/sprites.json" ]);
        loader.onComplete = function(){
            that.onAssetLoaded();
            callback(that);
            that.renderer.render(that.stage);
        };
        loader.load();
    };

    /**
     * Load textures and create map
     */
    World.prototype.onAssetLoaded = function(){
        var that = this;
        this.terrainMap.forEach(function(t){
            var terrain = that.makeSprite(t.code, t.x, t.y);
            that.stage.addChild(terrain);

            /*
            terrain.setInteractive(true);
            terrain.click = terrain.clap = function(data){
                console.log(data+" type="+iconeTerrain+" x:"+x+" y:"+y+" width:"+terrain.width+" height:"+terrain.height);
            }
            */
        });
    };

    World.prototype.doAction = function(action)
    {
        switch(action.what){
            case 'make':
                var sprite = this.makeSprite(
                    action.target.code,
                    action.who.x,
                    action.who.y
                );
                this.referencesMap[action.target.reference] = sprite;
                this.stage.addChild(sprite);
                break;
            case 'moveTo':
                var sprite = this.referencesMap[action.who.reference];
                sprite.position.x = (action.target.x+1)*16*scale;
                sprite.position.y = (action.target.y+1)*16*scale;
                break;
            default:
                break;
        }

        this.renderer.render(this.stage);
    }

    /**
     * Undo an action
     * @param action
     */
    World.prototype.undoAction = function(action)
    {
        switch(action.what){
            case 'make':
                var sprite = this.referencesMap[action.target.reference];
                this.stage.removeChild(sprite);
                this.referencesMap[action.target.reference] = null;
                // @todo my javascript is rusty, how do you clean that reference ?
                break;
            case 'moveTo':
                var sprite = this.referencesMap[action.who.reference];
                sprite.position.x = (action.who.x+1)*16*scale;
                sprite.position.y = (action.who.y+1)*16*scale;
                break;
            default:
                break;
        }

        this.renderer.render(this.stage);
    }

    World.prototype.makeSprite = function(code, x, y) {
        if(! code){
            console.error('no code provided');
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

        return terrain

    };

    document.World = World;
})(document, PIXI);
