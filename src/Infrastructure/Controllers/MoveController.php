<?php

namespace Kata\Infrastructure\Controllers;

use Kata\Application\Services\MoveService;
use Kata\Domain\Entities\EvGrid;
use Kata\Domain\Interfaces\EvInterface;

class MoveController
{
    private $output;
    private $evGrid;

    /**
     * @param EvInterface $output
     * @param EvGrid $evGrid
     */
    public function __construct(EvInterface $output, EvGrid $evGrid)
    {
        $this->output = $output;
        $this->evGrid = $evGrid;
    }

    /**
     * @param string $position
     * @param string $exploreArea
     * @return void
     */
    public function __invoke(string $position, string $exploreArea): void
    {

        // Call service move MoveService
        $outputMove = new MoveService($this->output, $this->evGrid);
        // Move it
        $outputMove($position, $exploreArea);

    }

}