<?php

namespace Forkwars\World;

use Forkwars\World\Unit\Unit;

class Team
{
    const TEAM_RED  = 'red';
    const TEAM_BLUE = 'blue';
    const TEAM_NONE = 0;

    private $bankAmount;

    private $priceCatalog;

    public function __construct(
        $startingBankAmount,
        $priceCatalog
    ) {
        $this->bankAmount   = $startingBankAmount;
        $this->priceCatalog = $priceCatalog;
    }

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