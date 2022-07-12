<?php

namespace Kata\Domain\ValueObjects;

class ExploreArea
{
    private string $exploreArea;

    /**
     * @param string $exploreArea
     */
    public function __construct(string $exploreArea)
    {
        $this->exploreArea = $exploreArea;
    }

    public function __toString()
    {
        return $this->exploreArea;
    }

    /**
     * @param $exploreArea
     * @return bool
     */
    public function validateExploreArea($exploreArea): bool
    {
        $exploreAreaPerUnits = str_split($exploreArea);
        foreach ($exploreAreaPerUnits as $exploreAreaPerUnit){
            if(!in_array($exploreAreaPerUnit, array("M", "L", "R"), true)){
                return false;
            }
        }
        return true;
    }


}