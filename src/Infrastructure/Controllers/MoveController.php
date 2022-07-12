<?php

namespace Kata\Infrastructure\Controllers;

use Kata\Application\Services\MoveService;
use Kata\Domain\Entities\EvGrid;
use Kata\Domain\Interfaces\EvInterface;
use Kata\Domain\ValueObjects\ExploreArea;
use Kata\Domain\ValueObjects\Position;

class MoveController
{
    private EvInterface $output;
    private EvGrid $evGrid;

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
     * @param Position $position
     * @param ExploreArea $exploreArea
     * @return void
     */
    public function __invoke(Position $position, ExploreArea $exploreArea): void
    {
        // Call service move MoveService
        $outputMove = new MoveService($this->output, $this->evGrid);
        // Move it
        $response = $outputMove(new Position($position), new ExploreArea($exploreArea));

    }

}