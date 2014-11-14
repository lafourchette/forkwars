<?php

namespace Forkwars\World\Unit;

use Forkwars\Position;
use Forkwars\World\Thing;

class Infantry extends Unit
{
    /**
     * @var string $code Terrain code, for string representation
     */
    protected $code = 'infantry';

    public $moveCount = 1;

    public function moveTo(Position $to)
    {
        $this->setWorldPosition($to);
    }

    public function moveToward(Thing $target)
    {
        $b = $target->getWorldPosition();
        $a = $this->getWorldPosition();
        $dx = $b->x - $a->x;
        $dy = $b->y - $a->y;
        if(abs($dx) > abs($dy)){ // shall move on x axis
            $this->getWorldPosition()->x += $dx > 0 ? 1 : -1;
        } else {
            $this->getWorldPosition()->y += $dy > 0 ? 1 : -1;
        }
    }

    public function capture()
    {
        // current terrain must be capturable
        throw new \Exception('Won the game');
    }
}
