<?php

namespace Kata\Application\Services;

use Kata\Domain\Entities\Ev;
use Kata\Domain\Interfaces\EvInterface;

class MoveService
{
    private $output;

    function __construct(EvInterface $output)
    {
        $this->output = $output;
    }

    public function __invoke($position, $exploreArea): void
    {

        // Buid de Ev Object
        $ev = new Ev($position, $exploreArea);
        // Move it
        $this->output->move($ev);
    }

}