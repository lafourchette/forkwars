<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Action;
use Forkwars\World\Unit\Unit;

class Factory extends Terrain
{
    /**
     * @param $something
     * @return Unit
     */
    public function make($something)
    {
        $unit = new Unit(); // always infantry haha
        $this->addChild($unit);
        $this->registerReference($unit);
        $this->registerAction(new Action($this, 'make', $unit));
        return $unit;
    }
}
