<?php

namespace Forkwars\World\Unit;

use Forkwars\Position;
use Forkwars\World\Action;
use Forkwars\World\Terrain\Terrain;
use Forkwars\World\Thing;

/**
 * Something that can move. Always part of a team.
 */
class Unit extends Thing
{
    public function getPosition()
    {
        return $this->getParent()->getPosition();
    }

    /**
     * @param Position $position
     * @return Action
     */
    public function moveTo(Thing $destination)
    {
        // @todo canMove
        // @todo destination is Reachable ?
        $this->setParent($destination);

        $destination->registerAction(new Action(
            $this,
            'moveTo',
            $destination
        ));
    }
}
