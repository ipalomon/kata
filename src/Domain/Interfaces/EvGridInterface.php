<?php

namespace Kata\Domain\Interfaces;

use Kata\Domain\Entities\EvGrid;

interface EvGridInterface
{
    public function addPosition(EvGrid $evGrid):void;
}