<?php

namespace Kata\Infrastructure\Persistence;

use Kata\Domain\Entities\Ev;
use Kata\Domain\Interfaces\EvInterface;

/**
 *
 */
class DoctrinePersistenceAdapter implements EvInterface
{
    /**
     * @param Ev $ev
     * @return void
     */
    public function save(Ev $ev): void
    {
        // Save data into BBDD

    }
}