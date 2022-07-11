<?php

namespace Kata\Infrastructure\Controllers;

use Kata\Application\Services\MoveService;
use Kata\Domain\Interfaces\EvInterface;

class MoveController
{
    private $output;

    /**
     * @param EvInterface $output
     */
    public function __construct(EvInterface $output)
    {
        $this->output = $output;
    }

    public function __invoke($position, $exploreArea): void
    {

        // Call service move MoveService
        $outputMove = new MoveService($this->output);
        // Move it
        $outputMove($position, $exploreArea);

    }

}