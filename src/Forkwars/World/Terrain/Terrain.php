<?php

namespace Forkwars\World\Terrain;

use Forkwars\General\GeneralInterface;
use Forkwars\World\Action;
use Forkwars\World\Thing;

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

    public function getTeam()
    {
        if(isset($this->metadata['team'])){
            return $this->metadata['team'];
        }
        return GeneralInterface::NONE;
    }

    public function getPosition()
    {
        return $this->getParent()->getPosition();
    }

    public function canHeal()
    {
        return $this->hasMetadataAndTrue('healing');
    }

    private function returnMandatoryMetadata($name)
    {
        if(! isset($this->metadata[$name])){
            throw new \LogicException($name . ' shall be set');
        }
        return $this->metadata[$name];
    }

    private function hasMetadataAndTrue($name)
    {
        return isset($this->metadata[$name]) && $this->metadata[$name];
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

    public function log($message)
    {
        $this->registerAction(new Action($this, 'log', $message));
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
