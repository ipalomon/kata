<?php

namespace Kata\Infrastructure\Controllers;

use Kata\Application\Services\OutputMove;
use Kata\Domain\Interfaces\OutPut;

class OutputController
{
    private $output;

    public function __construct(OutPut $output)
    {
        $this->output = $output;
    }

    public function __invoke($position, $exploreArea, $limit): void
    {

        // Call service move OutputMove
        $outputMove= new OutputMove($this->output);
        // Move it
        $outputMove($position, $exploreArea, $limit);

    }

}