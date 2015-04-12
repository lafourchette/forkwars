<?php

namespace Forkwars\World\Terrain;

use Forkwars\General\GeneralInterface;
use Forkwars\World\Action;
use Forkwars\World\Thing;

/**
 * Class Terrain
 * @package Forkwars\World\Terrain
 * @todo canHeal
 * @todo log ?
 */
class Terrain extends Thing
{
    public function __construct(array $metadata)
    {
        $this->metadata = $metadata;
    }

    public function getName()
    {
        return $this->returnMandatoryMetadata('name');
    }

    private function returnMandatoryMetadata($name)
    {
        if(! isset($this->metadata[$name])){
            throw new \LogicException($name . ' shall be set');
        }
        return $this->metadata[$name];
    }

    /**
     * {@inheritdoc}
     *
     * Terrain delegates action registering to World.
     */
    public function registerAction(Action $action)
    {
        return $this->getParent()->registerAction($action);
    }

    /**
     * {@inheritdoc}
     *
     * Terrain delegates referencing to World.
     */
    public function registerReference(Thing $thing)
    {
        return $this->getParent()->registerReference($thing);
    }
}
