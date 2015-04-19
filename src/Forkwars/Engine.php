<?php

namespace Forkwars;

use Forkwars\Service\CodeToThing;
use Forkwars\Service\MapToScene;

class Engine extends \Pimple\Container
{
    public function __construct()
    {
        parent::__construct();
        $e = $this; // e for engine

        $e['factory.code_to_thing'] = function () use ($e) {
            $definitions = json_decode(file_get_contents(__DIR__.'/../../data/things.json'), true);
            return new CodeToThing($definitions);
        };

        $e['factory.map_to_scene'] = function () use ($e) {
            return new MapToScene(
                $e['factory.code_to_thing']
            );
        };
    }
}