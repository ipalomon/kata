<?php

namespace Kata\Infrastructure\Adapters;

use Kata\Domain\Entities\Ev;
use Kata\Domain\Interfaces\EvInterface;

class MoveEvInterfaceAdapter implements EvInterface
{
    public function move(Ev $ev): void
    {
        echo $ev->getExploreArea()." ".$ev->getPosition();
    }
}