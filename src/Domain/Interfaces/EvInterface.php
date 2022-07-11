<?php

namespace Kata\Domain\Interfaces;

use Kata\Domain\Entities\Ev;

interface EvInterface
{
    public function save(Ev $ev): void;
}