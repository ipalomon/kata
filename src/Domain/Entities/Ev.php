<?php

namespace Kata\Domain\Entities;

class Ev
{
    private $evId;
    private $position;
    private $exploreArea;
    private $limit;

    /**
     * @param string $position
     * @param string $exploreArea
     * @param string $limit
     */
    public function __construct(string $position, string $exploreArea, string $limit)
    {
        $this->position = $position;
        $this->exploreArea = $exploreArea;
        $this->limit = $limit;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position): void
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getExploreArea()
    {
        return $this->exploreArea;
    }

    /**
     * @return string
     */
    public function getLimit(): string
    {
        return $this->limit;
    }

    /**
     * @param string $limit
     */
    public function setLimit(string $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @param mixed $exploreArea
     */
    public function setExploreArea($exploreArea): void
    {
        $this->exploreArea = $exploreArea;
    }



}