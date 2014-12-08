<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Action;
use Forkwars\World\Team;
use Forkwars\World\Thing;

class Terrain extends Thing
{
    public $shelterPower;

    public $footCost  = null;

    public $tyreCost  = null;

    public $trackCost = null;

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
        return Team::TEAM_NONE;
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

    public function registerAction(Action $action)
    {
        return $this->getParent()->registerAction($action);
    }
}
