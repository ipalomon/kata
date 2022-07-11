<?php

namespace Kata\Domain\Entities;

class Ev
{
    private $evId;
    private $position;
    private $exploreArea;

    /**
     * @param string $position
     * @param string $exploreArea
     */
    public function __construct(string $position, string $exploreArea)
    {
        $this->position = $position;
        $this->exploreArea = $exploreArea;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getExploreArea(): string
    {
        return $this->exploreArea;
    }

     /**
     * @param string $exploreArea
     */
    public function setExploreArea(string $exploreArea): void
    {
        $this->exploreArea = $exploreArea;
    }



}