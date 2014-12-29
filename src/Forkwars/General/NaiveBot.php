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
    public function doActions(World $world)
    {
        $factory     = $world->findOne('factory');
        $headquarter = $world->findOne('headquarter');
        $infantry    = $world->findOne('infantry');
        if(! $infantry){
            $factory->make('infantry');
            return;
        }
        if($infantry->getParent() != $headquarter){
            $infantry->moveTo($headquarter);
            return;
        }
        else{
            $infantry->capture();
            return;
        }
    }
}
