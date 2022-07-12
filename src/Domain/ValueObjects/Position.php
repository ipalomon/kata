<?php

namespace Kata\Domain\ValueObjects;

final class Position
{
    private string $position;

    /**
     * @param string $position
     */
    public function __construct(string $position)
    {
        $this->position = $position;
    }

    public function __toString()
    {
       return $this->position;
    }

    public function validateCoordinatesAndOrientation($position):bool{
        $coordinatesXyOrientation = $this->getCoordinatesAndOrientation($position);
        if(count($coordinatesXyOrientation) > 3){
            return false;
        }
        if(!ctype_digit((string) $coordinatesXyOrientation[0])){
            return false;
        }
        if(!ctype_digit((string) $coordinatesXyOrientation[1])){
            return false;
        }
        if(is_numeric( $coordinatesXyOrientation[2])){
            return false;
        }else{
            if(!in_array($coordinatesXyOrientation[2], array("N", "S", "E", "W"), true)){
                return false;
            }
        }

        return true;
    }

    public function getCoordinatesAndOrientation($position): array
    {
        return explode(" ", $position);
    }

}