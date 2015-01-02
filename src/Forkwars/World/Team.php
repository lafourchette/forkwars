<?php

//@todo should be elsewhere, thats game logic
namespace Forkwars\World;

class Team
{
    const TEAM_NONE = 0;
    const TEAM_RED  = 1;
    const TEAM_BLUE = 2;

    private $bankAmount;

    private $priceCatalog;
/*
    public function __construct(
        $startingBankAmount,
        $priceCatalog
    ) {
        $this->bankAmount   = $startingBankAmount;
        $this->priceCatalog = $priceCatalog;
    }
*/
    public function buy($unitClass)
    {
        if (! $this->canBuy($unitClass)) {
            throw new \Exception('cannot buy ' . $unitClass);
        }


    }

    public function canBuy($unitClass)
    {
        return false;
    }
} 