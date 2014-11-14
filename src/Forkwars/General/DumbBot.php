<?php

namespace Forkwars\General;
use Forkwars\World\World;

use Forkwars\World\Unit\Infantry;
use Forkwars\World\World;
use Forkwars\World\Thing;
use Forkwars\World\Algorithm\ReachablePositionsAlgorithm;

/**
 * Dumbot creates an infantry and make it walk randomly.
 *
 * He is the dumbest general ever.
 */
class DumbBot implements GeneralInterface
{
    public function giveOrders(World $world)
    {
        $infantry = $world->find('Infantry', Thing::TEAM_RED);
        if ($infantry) {
            $positions = $world->getNeighboringPositions($infantry->getWorldPosition());
            $target = $positions[rand(0, count($positions) - 1)];
            $infantry->moveTo($target);
        } else {
            $factory = $world->find('Factory', Thing::TEAM_RED);
            if(! $factory){throw new \Exception('No factory found');}
            $factory->spawn(new Infantry());
        }

        return array(
            $order
        );
    }
}
