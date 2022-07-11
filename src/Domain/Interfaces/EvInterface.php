<?php

namespace Kata\Domain\Interfaces;

use Kata\Domain\Entities\Ev;

interface EvInterface
{
    public function move(Ev $ev): void;
}