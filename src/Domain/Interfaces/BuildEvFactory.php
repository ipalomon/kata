<?php

namespace Kata\Domain\Interfaces;

interface BuildEvFactory
{
    public static function build(): EvInterface;
}