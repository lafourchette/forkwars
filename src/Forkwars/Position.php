<?php

namespace Forkwars;

class Position
{
    public $x, $y;

    function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
}