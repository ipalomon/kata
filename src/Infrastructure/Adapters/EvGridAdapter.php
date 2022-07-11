<?php

namespace Kata\Infrastructure\Adapters;

use Kata\Domain\Entities\EvGrid;
use Kata\Domain\Interfaces\EvGridInterface;


class EvGridAdapter implements EvGridInterface
{
    /**
     * @param EvGrid $evGrid
     * @return EvGrid
     */
    public function addPosition(EvGrid $evGrid):EvGrid
    {
        return $evGrid;
    }

}