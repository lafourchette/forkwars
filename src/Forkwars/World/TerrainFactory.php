<?php

namespace Forkwars\World;

use Forkwars\Exception\TerrainException;
use Forkwars\General\GeneralInterface;
use Forkwars\World\Terrain\Metadata;
use Forkwars\World\Terrain\Terrain;

/**
 * Given a description file, makes a terrain given a code.
 */
class TerrainFactory
{
    private $codeMap;

    private $availableTeams = array();

    /**
     * @param array $description
     */
    public function __construct(array $description)
    {
        $codes = array(
            'code'      => Team::TEAM_NONE,
            'blueCode'  => Team::TEAM_BLUE,
            'redCode'   => Team::TEAM_RED
        );

        foreach ($description as $metadata) {
            $this->mapTeam($metadata, $codes);
        }
    }

    protected function mapTeam(Metadata $metadata, array $codes)
    {
        if (array_key_exists($metadata->getLabel(),$codes)) {
            $this->codeMap[$metadata->getCode()]         = $metadata->__toArray();
            $this->codeMap[$metadata->getCode()]['team'] = $codes[$metadata->getLabel()];

            if (null !== $metadata->getClass()) {
                $this->codeMap[$metadata->getCode()]['class'] = $metadata->getClass();
            }
        }
    }

    public function setAvailableTeams(array $teams)
    {
        $this->availableTeams = $teams;
    }

    private function getTeam($teamConstant)
    {
        if(! isset($this->availableTeams[$teamConstant])){
            throw new TerrainException('cannot find a team for ' . $teamConstant);
        }
        return  $this->availableTeams[$teamConstant];
    }

    public function make($code)
    {
        if(! isset($this->codeMap[$code])) {
            throw new TerrainException('unknown terrain code ' . $code);
        }

        $className = $this->getCLassName($code);
        $terrain   = new $className($this->codeMap[$code]);

        if(isset($this->codeMap[$code]['team'])){
            $terrain->setTeam($this->getTeam($this->codeMap[$code]['team']));
        }
        return $terrain;
    }

    protected function getCLassName($code)
    {
        $className = 'Forkwars\\World\\Terrain\\Terrain';

        // Ability to use other classes. Keeps the code isolated.
        if(isset($this->codeMap[$code]['class'])){
            $className = 'Forkwars\\World\\Terrain\\' . $this->codeMap[$code]['class'];
            unset($this->codeMap[$code]['class']);
        }

        return $className;
    }
}
