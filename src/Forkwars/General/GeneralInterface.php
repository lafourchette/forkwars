<?php

namespace Forkwars\General;
use Forkwars\World\World;

/**
 * Can give orders when looking at a world map.
 *
 * We assume his main objective is to rule th world.
 * Holds all informations about a General
 *
 * Please note that on contrary to the original game, Generals have no
 * special powers.
 *
 */
interface GeneralInterface
{
    const RED = 'red';
    const BLUE= 'blue';
    const NONE= 'none';

    /**
     * @param World $world
     * @return void
     */
    public function doActions(World $world);
}
