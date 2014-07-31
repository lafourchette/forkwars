<?php

namespace Forkwars\General;

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
        if ($infantry) {
            if ($infantry->isAt($opHQ)) {
                $order = $infantry->capture();
            } else {
                $order = $infantry->moveToward($opHQ);
            }
        } else {
            $order = $world->find('Factory', 0)->spawn('Infantry');
        }

        return array(
            $order
        );
    }
}
