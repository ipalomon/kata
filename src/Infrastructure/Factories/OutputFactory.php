<?php

namespace Kata\Infrastructure\Factories;


use Kata\Domain\Interfaces\BuildFactory;
use Kata\Domain\Interfaces\OutPut;
use Kata\Infrastructure\Adapters\MoveOutputAdapter;

class OutputFactory implements BuildFactory
{
    public static function build(): OutPut
    {
        return new MoveOutputAdapter();
    }
}