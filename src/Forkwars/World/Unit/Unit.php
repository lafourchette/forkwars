<?php

namespace Forkwars\World\Unit;

use Forkwars\Position;
use Forkwars\World\Action;
use Forkwars\World\Terrain\Terrain;
use Forkwars\World\Thing;
use Forkwars\World\Unit\UnitMovementException;

use Forkwars\World\Terrain\CapturableTerrain;

/**
 * Something that can move. Always part of a team.
 */
class Unit extends Thing
{
    public function __construct(array $metadata = array())
    {
        // Set 200 as the default unit movement credit if not set
        if(!isset($metadata["maxMovementByTurn"])) {
          $metadata['maxMovementByTurn'] = 200;
        }
        $this->metadata = $metadata;
        $this->metadata['currentMovementLeft'] = $this->metadata['maxMovementByTurn'];
    }
    public function getName()
    {
        return 'infantry';
    }

    public function getHealth()
    {
        return 10;
    }

    public function getMovementLeft()
    {
        return $this->returnMandatoryMetadata("currentMovementLeft");
    }
    public function resetMovementLeft() {
      $this->metadata["currentMovementLeft"] = $this->metadata["maxMovementByTurn"];
    }
    public function getPosition()
    {
        return $this->getParent()->getPosition();
    }
    public function log($message)
    {
        $this->registerAction(new Action($this, 'log', $message));
    }

    public function canMove(Thing $destination) {
      if($destination instanceof Terrain) {
        return $destination->getMovementCost() <= $this->getMovementLeft();
      }
      // If not moving to a terrain, allow movement
      return true;
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

        // canMove
        if($this->canMove($destination)) {
          if($destination instanceof Terrain) {
            $this->metadata["currentMovementLeft"] -= $destination->getMovementCost();
          }
        } else {
          throw new UnitMovementException("Not enough movement points to move to this position");
        }
        // @todo destination is Reachable ?

        $this->canMove($past, $destination);

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

    public function canMove(Thing $origin, Thing $destination)
    {
        if (!$origin->getPosition() instanceof Position || !$destination->getPosition() instanceof Position) {
            throw new \Exception('Can not move from position origin to position destination.');
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

    /**
     * {@inheritdoc}
     *
     * Unit delegates action registering to parent.
     */
    public function registerAction(Action $action)
    {
        $res = false;
        if ($parent = $this->getParent()) {
            $res = $parent->registerAction($action);
        }
        return $res;
    }
}
