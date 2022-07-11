<?php

namespace Kata\Infrastructure\Controllers;

use Kata\Application\Services\EvGridService;
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

    public function __invoke($position, $limit): void
    {
        $outputGrid = new EvGridService($this->output);
        $outputGrid($position, $limit);
    }

}