<?php

namespace Kata\Application\Services;

use Kata\Domain\Entities\EvGrid;
use Kata\Domain\Interfaces\EvGridInterface;

class EvGridService
{
    private $output;

    function __construct(EvGridInterface $output)
    {
        $this->output = $output;
    }

    public function __invoke($position, $limit): void
    {

        // Build de Grid Object
        $evGrid = new EvGrid($position, $limit);
        //
        $this->output->addPosition($evGrid);
    }
}