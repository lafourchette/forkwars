<?php

namespace Forkwars\General;

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
    function giveOrders(World $world);
}