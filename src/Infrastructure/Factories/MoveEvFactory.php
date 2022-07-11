<?php

namespace Kata\Infrastructure\Factories;


use Kata\Domain\Interfaces\BuildEvFactory;
use Kata\Domain\Interfaces\EvInterface;
use Kata\Infrastructure\Persistence\DoctrinePersistenceAdapter;

class MoveEvFactory implements BuildEvFactory
{
    /**
     * @return EvInterface
     */
    public static function build(): EvInterface
    {
        return new DoctrinePersistenceAdapter();
    }
}