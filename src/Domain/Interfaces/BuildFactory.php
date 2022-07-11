<?php

namespace Kata\Domain\Interfaces;

interface BuildFactory
{
    public static function build(): OutPut;
}