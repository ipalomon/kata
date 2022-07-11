<?php

namespace Kata\Infrastructure\Factories;


use Kata\Domain\Interfaces\BuildEvFactory;
use Kata\Domain\Interfaces\EvInterface;
use Kata\Infrastructure\Adapters\MoveEvInterfaceAdapter;

class MoveEvFactory implements BuildEvFactory
{
    public static function build(): EvInterface
    {
        return new MoveEvInterfaceAdapter();
    }
}