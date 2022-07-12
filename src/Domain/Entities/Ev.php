<?php

namespace Kata\Domain\Entities;

use Kata\Domain\ValueObjects\ExploreArea;
use Kata\Domain\ValueObjects\Position;

class Ev
{
    private $evId;
    private Position $position;
    private string $exploreArea;

    /**
     * @param Position $position
     * @param ExploreArea $exploreArea
     */
    public function __construct(Position $position, ExploreArea $exploreArea)
    {
        $this->position = $position;
        $this->exploreArea = $exploreArea;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @param Position $position
     */
    public function setPosition(Position $position): void
    {
        $this->position = $position;
    }

    /**
     * @return ExploreArea
     */
    public function getExploreArea(): ExploreArea
    {
        return $this->exploreArea;
    }

    /**
     * @param ExploreArea $exploreArea
     */
    public function setExploreArea(ExploreArea $exploreArea): void
    {
        $this->exploreArea = $exploreArea;
    }



}