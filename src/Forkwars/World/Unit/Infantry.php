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
        $this->setWorldPosition($to);
    }

    public function moveToward(Thing $target)
    {
        throw new \Exception('please do something');
    }
}
