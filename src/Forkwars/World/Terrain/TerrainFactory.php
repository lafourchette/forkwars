<?php

namespace Forkwars\World\Terrain;
use Symfony\Component\Finder\Finder;

/**
 * Transform a terrain code into a terrain
 */
class TerrainFactory
{
    protected $dictionary = array();

    function loadAvailableTerrains()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__)->name('*.php')->notContains('interface');
        foreach ($finder as $file) {
            // affiche le chemin absolu
            $className = 'Forkwars\\World\\Terrain\\' . substr($file->getBasename(), 0, -4);
            if (class_exists($className) &&
                in_array('Forkwars\World\Terrain\Terrain', class_parents($className))) {
                $this->dictionary[$className::getCode()] = $className;
            }
        }
    }

    /**
     * @param $terrainCode
     * @return Terrain A terrain
     */
    function make($terrainCode)
    {
        $className = $this->dictionary[$terrainCode];
        return new $className();
    }
}