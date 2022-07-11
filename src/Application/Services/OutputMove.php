<?php

namespace Kata\Application\Services;

use Kata\Domain\Entities\Ev;
use Kata\Domain\Interfaces\OutPut;

class OutputMove
{
    private $output;

    function __construct(OutPut $output)
    {
        $this->output = $output;
    }

    public function __invoke($position, $exploreArea, $limit): void
    {

        // Buid de Ev Object
        $ev = new Ev($position, $exploreArea, $limit);
        // Move it
        $this->output->move($ev);
    }

}