<?php

namespace Kata\Infrastructure\Adapters;

use Kata\Domain\Entities\Ev;
use Kata\Domain\Interfaces\OutPut;

class MoveOutputAdapter implements OutPut
{
    public function move(Ev $ev): void
    {
        echo $ev->getExploreArea()." ".$ev->getPosition(). " ".$ev->getLimit();
    }
}