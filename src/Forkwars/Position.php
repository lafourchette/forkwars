<?php

namespace Forkwars;

class Position
{
    public $x, $y;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function equals(Position $p)
    {
        return ($this->x == $p->x) && ($this->y == $p->y);
    }

    public function __toString()
    {
        return $this->x.'-'.$this->y;
    }
}
