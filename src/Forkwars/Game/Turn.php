<?php

namespace Forkwars\Game;


class Turn extends \SplStack
{
    private $day;

    public function setDay($day)
    {
        $this->day = $day;
    }


    public function toArray()
    {
        return array(
            'day' => $this->day,
            'actions' => iterator_to_array($this)
        );
    }
}