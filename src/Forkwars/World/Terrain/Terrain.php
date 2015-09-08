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
    public function __construct(array $metadata = array())
    {
        $this->metadata = $metadata;
    }

    public function getName()
    {
        return $this->returnMandatoryMetadata('name');
    }

    public function getMovementCost()
    {
        return $this->returnMandatoryMetadata('movementCost');
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
        $res = false;
        if ($parent = $this->getParent()) {
            $res = $parent->registerAction($action);
        }
        return $res;
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
