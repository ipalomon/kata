<?php

namespace Kata\Domain\Entities;

class EvGrid
{
    private $positions;
    private $limitXY;

    /**
     * @param array $positions
     * @param string $limitXY
     */
    public function __construct(array $positions, string $limitXY)
    {
        $this->positions = $positions;
        $this->limitXY = $limitXY;
    }

    /**
     * @return array
     */
    public function getPositions(): array
    {
        return $this->positions;
    }

    /**
     * @param array $positions
     */
    public function setPositions(array $positions): void
    {
        $this->positions = $positions;
    }

    /**
     * @return string
     */
    public function getLimitXY(): string
    {
        return $this->limitXY;
    }

    /**
     * @param string $limitXY
     */
    public function setLimitXY(string $limitXY): void
    {
        $this->limitXY = $limitXY;
    }


}