<?php

namespace Forkwars\World\Terrain;

class CapturableTerrain extends Terrain
{
    private $captureAmount = 20;

    public function canBeCapturedBy(Unit $unit)
    {
        return $unit->getTeam() != $this->getTeam();
    }

    public function captureBy(Unit $unit)
    {
        if(! $this->canBeCapturedBy($unit)){
            throw new \Exception('cannot capture');
        }
        $this->captureAmount -= $unit->health;
        if($this->captureAmount <= 0){
            $this->setTeam($unit->getTeam());
        }
        $this->resetCapture();
    }

    public function resetCapture()
    {
        $this->captureAmount = 20;
    }

    // @todo if capturing unit moves, captureAmount is reset
}
