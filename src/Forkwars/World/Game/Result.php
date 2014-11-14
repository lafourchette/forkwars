<?php

namespace Forkwars\World\Game;

class Result
{
    const IS_WINNER       = 'winner';
    const IS_LOSER        = 'loser';
    const IS_UNRESPONSIVE = 'unresponsive';
    const IS_CHEATER      = 'cheater';

    public function toJson()
    {
        return '[]';
    }
} 