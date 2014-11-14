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

    public $moveCount = 3;

    public function moveTo(Position $to)
    {
        return $this->setWorldPosition($to);
    }

    public function moveToward(Thing $target)
    {
        $b = $target->getPosition();
        $a = $this->getPosition();
        $dx = $b->x - $a->x;
        $dy = $b->y - $a->y;
        if(abs($dx) > abs($dy)){ // shall move on x axis
            $this->getPosition()->x += $dx > 0 ? 1 : -1;
        } else {
            $this->getPosition()->y += $dy > 0 ? 1 : -1;
        }
    }

    public function capture()
    {
        // current terrain must be capturable
        throw new \Exception('Won the game');
    }
}
