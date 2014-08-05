<?php

namespace Forkwars\World\Unit;

use Forkwars\Position;

class Infantry extends Unit
{
    public $moveCount = 3;

    public function moveTo(Position $to)
    {
        $this->setWorldPosition($to);
    }
}
