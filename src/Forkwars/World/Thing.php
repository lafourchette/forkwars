<?php

namespace Forkwars\World;

/**
 * Most basic type of thing in the game.
 */
class Thing
{
    public function getSprite()
    {
        throw new \Exception('no sprite');
    }

    public function getPosition()
    {

    }


}