<?php

namespace Kata\Domain\Interfaces;

use Kata\Domain\Entities\Ev;

interface OutPut
{
    public function move(Ev $ev): void;
}