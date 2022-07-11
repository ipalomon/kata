<?php

namespace Kata\Infrastructure\Adapters;

use Kata\Domain\Entities\EvGrid;
use Kata\Domain\Interfaces\EvGridInterface;

class EvGridAdapter implements EvGridInterface
{
    public function addPosition(EvGrid $evGrid):void
    {
        print_r($evGrid->getPositions());
        echo $evGrid->getLimitXY();
    }

}