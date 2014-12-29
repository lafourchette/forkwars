<?php

namespace Forkwars\World\Terrain;

use Forkwars\World\Unit\Unit;

class CapturableTerrain extends Terrain
{
    private $captureAmount = 20;

    /**
     * This function shall not be used by a general
     * @throws \Exception
     */
    public function capture($amount)
    {
        return $this->captureAmount = $this->captureAmount - $amount;
    }

    public function resetCapture()
    {
        $this->captureAmount = 20;
    }
}
