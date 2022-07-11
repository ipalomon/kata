<?php

namespace Kata\Infrastructure\Factories;

use Kata\Domain\Interfaces\BuildGridEvFactory;
use Kata\Domain\Interfaces\EvGridInterface;
use Kata\Infrastructure\Adapters\EvGridAdapter;

class EvGridFactory implements BuildGridEvFactory
{
    /**
     * @return EvGridInterface
     */
    public static function build(): EvGridInterface
    {
        return new EvGridAdapter();
    }
}