<?php

namespace Forkwars\General;
use Forkwars\World\World;

/**
 * Dumbot creates an infantry and make it walk randomly.
 *
 * He is the dumbest general ever.
 */
class DumbBot implements GeneralInterface
{
    public function doActions(World $world)
    {
        $infantry = $world->find('Infantry', 0);
        if ($infantry) {
            $infantry->move(rand(0, 3));
        } else {
            $world->find('Factory', 0)->spawn('Infantry');
        }
    }
}
