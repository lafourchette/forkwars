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

    public function getName()
    {
        return 'infantry';
    }

    public function getPosition()
    {
        return $this->getParent()->getPosition();
    }

    public function log($message)
    {
        $this->registerAction(new Action($this, 'log', $message));
    }

    /**
     * @param Position $position
     * @return Action
     */
    public function moveTo(Thing $destination)
    {
        $this->detach();
        $this->attachTo($destination);

        // @todo canMove
        // @todo destination is Reachable ?

        $destination->registerAction(new Action(
            $this,
            'moveTo',
            array(
                'x' => $destination->getPosition()->x,
                'y' => $destination->getPosition()->y
            )

        ));
    }

    /**
     * {@inheritdoc}
     *
     * Unit delegates action registering to parent.
     */
    public function registerAction(Action $action)
    {
        return $this->getParent()->registerAction($action);
    }
}
