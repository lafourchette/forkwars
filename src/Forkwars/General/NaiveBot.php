<?php

namespace Forkwars\General;
use Forkwars\World\Unit\Infantry;
use Forkwars\World\World;

/**
 * NaiveBot creates an infantry, make it run towards the
 * opponents headquarter and attempts to seize it.
 *
 * Retry if its infantry get killed.
 */
class NaiveBot implements GeneralInterface
{
    public function giveOrders(World $world)
    {
        $infantry = $world->find('Infantry', 0);
        $opHQ = $world->find('Headquarter', 1);
        if(! $opHQ){throw new \Exception('No headquarter found');}
        if ($infantry) {
            if ($infantry->isAt($opHQ)) {
                $infantry->capture();
            } else {
                $infantry->moveToward($opHQ);
            }
        } else {
            $factory = $world->find('Factory', 0);
            if(! $factory){throw new \Exception('No headquarter found');}
            $factory->spawn(new Infantry());
        }
    }
}
