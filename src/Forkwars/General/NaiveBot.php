<?php

namespace Forkwars\General;
use Forkwars\World\Unit\Infantry;
use Forkwars\World\World;
use Forkwars\World\Thing;

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
        $infantry = $world->find('Infantry', Thing::TEAM_RED);
        $opHQ = $world->find('Headquarter', Thing::TEAM_BLUE);
        if(! $opHQ){throw new \Exception('No headquarter found');}
        if ($infantry) {
            if ($infantry->isAt($opHQ)) {
                $infantry->capture();
            } else {
                $infantry->moveToward($opHQ);
            }
        } else {
            $factory = $world->find('Factory', Thing::TEAM_RED);
            if(! $factory){throw new \Exception('No factory found');}
            $factory->spawn(new Infantry());
        }
    }
}
