<?php

namespace Forkwars\World\Unit;

use Forkwars\Position;
use Forkwars\World\Action;
use Forkwars\World\Terrain\Terrain;
use Forkwars\World\Thing;

use Forkwars\World\Terrain\CapturableTerrain;

/**
 * Something that can move. Always part of a team.
 */
class Unit extends Thing
{
    public function getName()
    {
        return 'infantry';
    }

    public function getHealth()
    {
        return 10;
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
        $past = clone $this;
        $this->detach();
        $this->attachTo($destination);

        // @todo canMove
        // @todo destination is Reachable ?

        $destination->registerAction(new Action(
            $past,
            'moveTo',
            array(
                'x' => $destination->getPosition()->x,
                'y' => $destination->getPosition()->y
            )
        ));

        if($this->getParent() instanceof CapturableTerrain){
            $this->getParent()->resetCapture();
        }
    }

    /**
     * Capture the building where it stands
     * @todo the capture logic is here, maybe it is not the best place for it.
     */
    public function capture()
    {
        $success = false;
        /**
         * @var CapturableTerrain $parent
         */
        $parent  = $this->getParent();
        $captureLeft = $parent->capture(
            $this->getHealth()
        );
        $parent->registerAction(new Action(
            $this,
            'capture',
            $parent
        ));
        if ($captureLeft <= 0) {
            $parent->setTeam(
                $this->getTeam()
            );
            $parent->resetCapture();
            $parent->registerAction(new Action(
                $this,
                'log',
                'I captured my parent'
            ));
            $success = true;
        }
        return $success;
    }

    public function canCapture()
    {
        // return $unit->getTeam() != $this->getTeam();
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
