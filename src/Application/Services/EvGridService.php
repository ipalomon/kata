<?php

namespace Kata\Application\Services;

use Kata\Domain\Entities\EvGrid;
use Kata\Domain\Interfaces\EvGridInterface;

class EvGridService
{
    private $output;

    /**
     * Inject dependencies
     * @param EvGridInterface $output
     */
    function __construct(EvGridInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param $position
     * @param $limit
     * @return EvGrid
     */
    public function __invoke($position, $limit): EvGrid
    {

        // Build de Grid Object
        $evGrid = new EvGrid($position, $limit);
        // Return this Grid witch positions and one limit
        return $this->output->addPosition($evGrid);
    }
}