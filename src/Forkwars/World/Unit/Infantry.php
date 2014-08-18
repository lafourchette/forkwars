<?php

namespace Forkwars\World\Unit;

use Forkwars\Position;
use Forkwars\World\Thing;

class Infantry extends Unit
{
    public $moveCount = 3;

    public function moveTo(Position $to)
    {
        $this->setWorldPosition($to);
    }

    public function moveToward(Thing $target)
    {
        throw new \Exception('please do something');
    }
}
