<?php

namespace Forkwars;

use Forkwars\General;


/**
 * Runs a game until it ends.
 */
class Runner
{
    private $engine;

    function __construct(GeneralInterface $blue, GeneralInterface $red, World $world)
    {
        $engine = new \Forkwars\Engine($this->blue, $this->red, $this->world);
    }

    function run()
    {
        $winner = null;
        $max = 500; $i = 0;

        try{
            do {
                $this->engine->step();
                $winner = $this->engine->hasWinner();
                $i++;
            } while (is_null($winner) && ($i++ < $max));
        } catch(\Exception $e) {
            // got no winner
        }

        // @todo log informations about the game
    }
}