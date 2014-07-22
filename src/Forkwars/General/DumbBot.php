<?php

namespace Forkwars\General;

/**
 * Dumbot creates an infantry and make it walk randomly.
 *
 * He is the dumbest general ever.
 */
class DumbBot implements GeneralInterface
{
    function giveOrders(World $world)
    {
        $infantry = $world->find('Infantry', 0);
        if($infantry){
            $order = $infantry->move(rand(0, 3));
        } else {
            $order = $world->find('Factory', 0)->spawn('Infantry');
        }

        return array(
            $order
        );
    }
}