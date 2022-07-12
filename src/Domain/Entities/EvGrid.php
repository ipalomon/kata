<?php

namespace Kata\Domain\Entities;

use Kata\Domain\ValueObjects\Position;

/**
 * The Grid Have a positions Ev and the limit Grid
 */
class EvGrid
{
    private array $positions;
    private string $limitXY;

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

    public function setPosition(Position $position):void
    {
        $this->positions[] = $position;
    }


}