<?php

namespace Kata\Infrastructure\Controllers;

use Kata\Application\Services\EvGridService;
use Kata\Domain\Entities\EvGrid;
use Kata\Domain\Interfaces\EvGridInterface;

class EvGridController
{
    private $output;

    /**
     * @param EvGridInterface $output
     */
    public function __construct(EvGridInterface $output)
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
        $outputGrid = new EvGridService($this->output);
        return $outputGrid($position, $limit);

    }

}