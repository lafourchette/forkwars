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
            'actions' =>
                // @todo not ok
                array_values(
                    iterator_to_array($this)
                )
        );
    }
}