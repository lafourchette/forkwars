<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Action;
use Forkwars\World\Unit\Metadata as UnitMetadata;
use Forkwars\World\Unit\Unit;
use Forkwars\World\TerrainFactory;

class Factory extends Terrain
{
    /**
     * @param $something
     * @return Unit
     */
    public function make(UnitMetadata $metadata)
    {
        $unit = new Unit();

        $this->setParent($metadata->getParent());
        $this->registerReference($this->getRoot());
        $unit->setTeam($this->getTeam());

        if (null !== $metadata->getChild()) {
            $this->addChild($metadata->getChild());
        }

        if (null !== $metadata->getAction()) {
            $this->registerAction($metadata->getAction());
        }

        return $unit;
    }
}
